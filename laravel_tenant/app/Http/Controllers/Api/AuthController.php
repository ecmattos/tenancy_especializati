<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Entities\User;
use App\Entities\Client;
use Validator, DB, Hash, Mail, Auth;
use App\Validators\UserRegisterValidator;
use App\Validators\UserAdminRegisterValidator;
use App\Validators\UserVerifyValidator;
use App\Validators\UserRecoverValidator;
use App\Validators\LoginValidator;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\Mail\SendUserVerifyMailable;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\MessageBag;

use App\Events\Tenant\ClientCreated;
use App\Events\Tenant\DatabaseCreated;

class AuthController extends Controller
{
    protected $user_registerValidator;
    protected $user_admin_registerValidator;
    protected $loginValidator;
    protected $user_verifyValidator;
    protected $user_recoverValidator;

    public function __construct(UserRegisterValidator $user_registerValidator, UserAdminRegisterValidator $user_admin_registerValidator, LoginValidator $loginValidator, UserVerifyValidator $user_verifyValidator, UserRecoverValidator $user_recoverValidator)
    {
        $this->user_registerValidator  = $user_registerValidator;
        $this->user_admin_registerValidator  = $user_admin_registerValidator;
        $this->loginValidator  = $loginValidator;
        $this->user_verifyValidator  = $user_verifyValidator;
        $this->user_recoverValidator  = $user_recoverValidator;
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
            
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 400);
        }
        
        $credentials['is_verified'] = 1;

        $bag = new MessageBag();
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                $bag->add('email', 'Desculpe mas não localizamos a sua conta');
                $bag->add('password', 'Ou senha incorreta.');
                return response()->json([
                    'errors' => $bag
                ], 400);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'success' => false, 
                'errors' => 'Failed to login, please try again.'
            ], 400);
        }

        // all good so return the token
        return $this->respondWithToken($token);

    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) 
    {        
        $this->validate($request, [
            'token' => 'required'
        ]);
        
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json([
                'success' => true, 
                'message'=> "You have successfully logged out."
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'success' => false, 
                'errors' => 'Failed to logout, please try again.'
            ], 400);
        }
    }

    public function register(Request $request)
    {
        $input = $request->all();
        
        try {
            $this->user_registerValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $name = $input['name'];
            $email = $input['email'];
            $password = $input['password'];
            
            $user = User::create([
                'name' => $name, 
                'email' => $email, 
                'password' => Hash::make($password)
            ]);
            
            $code_verification = str_random(30); //Generate verification code

            DB::connection('mysql')->table('user_verifications')->insert([
                'user_id' => $user->id,
                'token' => $code_verification
            ]);
            
            $subject = "SiGeS - Confirmação de cadastro";
            
            Mail::to($email)
            ->send(new SendUserVerifyMailable($subject, $name, $code_verification));
            
            return response()->json([
                'success'=> true, 
                'message'=> 'Obrigado pelo seu cadastro ! Verifique o seu e-mail para completar o cadastro.'
            ]);

        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => $e->getMessageBag()
                ], 400);
            }
        }
       
    }

    public function registerAdmin(Request $request)
    {
        $input = $request->all();

        #dd($input);

        $code_verification = $input['codeVerification'];
        
        try {
            $this->user_admin_registerValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $check = DB::connection('mysql')->table('client_verifications')->where('token',$code_verification)->first();
            #dd($check);
            $bag = new MessageBag();
                
            if(!is_null($check))
            {
                $client = Client::find($check->client_id);
                if($client->is_verified == 1)
                {
                    $bag->add('codeVerification', 'Conta já verificada.');
                    return response()->json([
                        'errors' => $bag
                    ]);
                }
                
                DB::connection('mysql')->table('clients')->update(['is_verified' => 1]);
                
                DB::connection('mysql')->table('client_verifications')->where('token',$code_verification)->delete();
                
                $name = $input['name'];
                $email = $input['email'];
                $password = $input['password'];
                
                $user = User::create([
                    'client_id' => $client->id,
                    'name' => $name, 
                    'email' => $email, 
                    'password' => Hash::make($password),
                    'role' => 'Admin',
                    'is_verified' => 1
                ]);

                if(true)
                {
                    event(new ClientCreated($client));
                }
                else
                {
                    event(new DatabaseCreated($client));
                }
                
                return response()->json([
                    'success'=> true,
                    'message'=> 'Conta Administrador criada com sucesso !'
                ]);
            }
                
            $bag->add('codeVerification', 'Inválido. Verifique novamente o seu e-mail.');
            return response()->json([
                'errors' => $bag
            ], 400);

        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => $e->getMessageBag()
                ], 400);
            }
        }
       
    }


    /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recovery(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];

        try {
                $this->user_recoverValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

                $bag = new MessageBag();
                
                $user = User::where('email', $email)->first();
                if (!$user) {
                    $bag->add('email', 'Inexistente.');
                    return response()->json([
                        'errors' => $bag
                    ], 400);
                }

                try {
                    Password::sendResetLink($request->only('email'), function (Message $message) {
                        $message->subject('Senha de Acesso: Alteração ');
                    });
                } catch (\Exception $e) {
                    //Return with error
                    $error_message = $e->getMessage();
                    return response()->json([
                        'success' => false, 
                        'errors' => $error_message
                    ], 400);
                }


                return response()->json([
                    'success' => true, 
                    'data'=> [
                        'message'=> 'A reset email has been sent! Please check your email.'
                    ]
                ]);

            } catch (ValidatorException $e) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'errors' => $e->getMessageBag()
                    ], 400);
                }
            }
    }

    /**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $input = $request->all();
        
        $code_verification = $input['codeVerification'];
        
        try {
                $this->user_verifyValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

                $check = DB::connection('mysql')->table('user_verifications')->where('token',$code_verification)->first();
                #dd($check);
                $bag = new MessageBag();
                
                if(!is_null($check)){
                    $user = User::find($check->user_id);
                    if($user->is_verified == 1){
                        $bag->add('codeVerification', 'Conta já verificada.');
                        return response()->json([
                            'errors' => $bag
                        ]);
                    }
                    $user->update(['is_verified' => 1]);
                
                    DB::connection('mysql')->table('user_verifications')->where('token',$code_verification)->delete();
                    return response()->json([
                        'success'=> true,
                        'message'=> 'Conta verificada com sucesso !'
                    ]);
                }
                
                
                $bag->add('codeVerification', 'Inválido. Verifique novamente o seu e-mail.');
                return response()->json([
                    'errors' => $bag
                ], 400);

            } catch (ValidatorException $e) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'errors' => $e->getMessageBag()
                    ], 400);
                }
            }
    }

    public function user($token)
    {
        return JWTAuth::setToken($token)->toUser();
    }

    public function refresh()
    {
        #return $this->respondWithToken($this->guard()->refresh());
        $token = JWTAuth::getToken();
        #dd($token);
        if (!$token) {
            return $this->error('Token NOT provided!', 400);        
        }

        $token = JWTAuth::refresh($token);

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        #return response()->json([
        #    'token' => $token,
        #    'token_type' => 'bearer',
        #    'expires_in' => $this->guard()->factory()->getTTL() * 60
        #]);

        $user = $this->user($token);
        
        return response()->json([
            'success' => true, 
            'access_token' => [ 
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->guard()->factory()->getTTL() * env('JWT_TTL')
            ],
            'user' => $user,
            'client' => $user->client
        ], 200);
    }

     /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
