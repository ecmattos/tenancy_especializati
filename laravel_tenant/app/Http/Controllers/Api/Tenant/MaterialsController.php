<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\MaterialRepository;
use App\Validators\MaterialSearchValidator;
use App\Validators\MaterialValidator;
use App\Transformers\MaterialTransformer;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class MaterialsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class MaterialsController extends Controller
{
    /**
     * @var MaterialRepository
     */
    protected $materialRepository;

    /**
     * @var MaterialSearchValidator
     */
    protected $materialSearchValidator;

     /**
     * @var MaterialValidator
     */
    protected $materialValidator;
     
    /**
     * MaterialsController constructor.
     *
     * @param MaterialRepository $materialRepository
     * @param MaterialSearchValidator $materialSearchValidator
     * @param MaterialValidator $materialValidator
     */
    public function __construct(MaterialRepository $materialRepository, MaterialSearchValidator $materialSearchValidator, MaterialValidator $materialValidator)
    {
        $this->materialRepository = $materialRepository;
        $this->materialRepository->skipPresenter(true);
        
        $this->materialSearchValidator  = $materialSearchValidator;
        $this->materialValidator  = $materialValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$this->materialRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $materials = $this->materialRepository->all();

        return response()->json([
            'success' => true,
            'message' => 'Operação realizada !',
            'data' => $materials
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchDescription(Request $request)
    {
        $input = $request->all();
                       
        try {
            $this->materialSearchValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $srch_material_terms = $input['description_terms'];
            
            $materials = $this->materialRepository->materialsSearchDescription($srch_material_terms);

            //$materials = (new MaterialTransformer)->transform($materials);

            return response()->json([
                'success'  => true,
                'materials' => $materials, 
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchCode(Request $request)
    {
        $input = $request->all();

        try 
        {
            $this->materialSearchValidator->with($request->all())->passesOrFail();

            $srch_material_terms = $input['params'];

            $material = $this->materialRepository->materialsSearchCode($srch_material_terms);
            #$material = $this->materialRepository->skipCriteria()->findByField('code', $srch_material_terms);
            #$material = $this->materialRepository->findWhere(['code'=>$srch_material_terms,'code'=>$srch_material_terms])->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Operação realizada !',
                'material' => $material
            ]);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        #dd($input);
        
        try {
            $this->materialValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $material = $this->materialRepository->create($input);

            return response()->json([
                'success' => true,
                'material' => $material, 
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $material = $this->materialRepository->find($id);

        $material = $this->materialTransformer->transform($material);

        return response()->json([
            'success' => true,
            'message' => 'Operação realizada !',
            'data' => $material
        ]);
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
        $material = $this->materialRepository->find($id);

        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MaterialUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MaterialUpdateRequest $request, $id)
    {
        try {

            $this->materialValidator->with($request->all())->passesOrFail();

            $material = $this->materialRepository->update($request->all(), $id);

            $response = [
                'message' => 'Material updated.',
                'data'    => $material->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'errors' => $e->getMessageBag()
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
        $deleted = $this->materialRepository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Material deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Material deleted.');
    }
}
