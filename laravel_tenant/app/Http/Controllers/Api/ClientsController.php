<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Repositories\ClientRepository;
use App\Validators\ClientValidator;
use App\Validators\ClientVerifyValidator;
use App\Events\Tenant\ClientCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Mail\SendClientVerifyMailable;
use App\Entities\User;
use Illuminate\Support\MessageBag;
use DB, Mail;

/**
 * Class ClientsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class ClientsController extends Controller
{
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $clientValidator;
    protected $clientVerifyValidator;

    /**
     * ClientsController constructor.
     *
     * @param ClientRepository $repository
     * @param ClientValidator $clientValidator
     */
    public function __construct(ClientRepository $repository, ClientValidator $clientValidator, ClientVerifyValidator $clientVerifyValidator)
    {
        $this->repository = $repository;
        $this->clientValidator  = $clientValidator;
        $this->clientVerifyValidator  = $clientVerifyValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $clients = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clients,
            ]);
        }

        return view('clients.index', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $input['code'] = $this->generateCode();
        $input['domain'] = env("DOMAIN");
        $input['database'] = env('DB_DATABASE')."_".$input['code'];
        $input['hostname'] = env('DB_HOST');
        $input['username'] = env('DB_USERNAME');
        $input['password'] = env('DB_PASSWORD');

        #dd($input);
                       
        try {
            $this->clientValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $client = $this->repository->create($input);
            
            $code_verification = str_random(30); //Generate verification code

            DB::connection('mysql')->table('client_verifications')->insert([
                'client_id' => $client->id,
                'token' => $code_verification
            ]);

            $subject = "SiGeS - Confirmação de cadastro";
            
            Mail::to($client->email)
            ->send(new SendClientVerifyMailable($subject, $client->name, $code_verification));
            
            return response()->json([
                'success'=> true, 
                'message'=> 'Obrigado pelo seu cadastro ! Verifique o seu e-mail para completar o cadastro.'
            ]);

            return response()->json([
                'success'  => true,
                'client' => $client, 
                'messages' => 'Operação realizada com sucesso!'
            ]);

        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => $e->getMessageBag()
                ], 400);
            }
        }
    }

    public function generateCode()
	{
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $charsLength = strlen($chars);
        
        $size = 10;

        $codeRandomString = '';
        
        for($i = 0; $i < $size; $i++)
        {
           $codeRandomString .= $chars[rand(0, $charsLength - 1)];
		}
        
        return $codeRandomString;
	 }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $client,
            ]);
        }

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = $this->repository->find($id);

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        try {

            $this->clientValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $client = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Client updated.',
                'data'    => $client->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Client deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Client deleted.');
    }

    /**
     * API Verify Client
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $input = $request->all();
        
        $code_verification = $input['codeVerification'];
        
        try {
                $this->clientVerifyValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

                $check = DB::connection('mysql')->table('client_verifications')->where('token',$code_verification)->first();
                #dd($check);
                $bag = new MessageBag();
                
                if(!is_null($check)){
                    $client = Client::find($check->client_id);
                    if($client->is_verified == 1){
                        $bag->add('codeVerification', 'Conta já verificada.');
                        return response()->json([
                            'errors' => $bag
                        ]);
                    }
                    $client->update(['is_verified' => 1]);

                    if($client)
                    {
                        event(new ClientCreated($client));
                    }
                    else
                    {
                        event(new DatabaseCreated($client));
                    }                    

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
                
                    DB::connection('mysql')->table('client_verifications')->where('token',$code_verification)->delete();
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
}
