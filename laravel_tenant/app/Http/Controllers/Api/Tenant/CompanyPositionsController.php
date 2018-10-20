<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CompanyPositionCreateRequest;
use App\Http\Requests\CompanyPositionUpdateRequest;
use App\Repositories\CompanyPositionRepository;
use App\Validators\CompanyPositionValidator;
use App\Transformers\CompanyPositionTransformer;

/**
 * Class CompanyPositionsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class CompanyPositionsController extends Controller
{
    /**
     * @var CompanyPositionRepository
     */
    protected $companyPositionRepository;

    /**
     * @var CompanyPositionValidator
     */
    protected $companyPositionValidator;

    /**
     * @var CompanyPositionTransformer
     */
    protected $companyPositionTransformer;

    /**
     * CompanyPositionsController constructor.
     *
     * @param CompanyPositionRepository $companyPositionRepository
     * @param CompanyPositionValidator $companyPositionValidator
     * @param CompanyPositionTransformer $companyPositionTransformer
     */
    public function __construct(CompanyPositionRepository $companyPositionRepository, CompanyPositionValidator $companyPositionValidator, CompanyPositionTransformer $companyPositionTransformer)
    {
        $this->companyPositionRepository = $companyPositionRepository;
        $this->companyPositionRepository->skipPresenter(true);

        $this->companyPositionValidator  = $companyPositionValidator;
        $this->companyPositionTransformer  = $companyPositionTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$this->companyPositionRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $companyPositions = $this->companyPositionRepository->all();

        //return $this->companyPositionTransformer->transform($companyPositions);
        return $companyPositions;
        
        /*
        $companyPositions = (new CompanyPositionTransformer)->transform($companyPositions);

        return response()->json([
            'success' => true,
            'message' => 'Operação realizada !',
            'data' => $companyPositions
        ]);

        #return view('companyPositions.index', compact('companyPositions'));
        */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyPositionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CompanyPositionCreateRequest $request)
    {
        try {

            $this->companyPositionValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $companyPosition = $this->companyPositionRepository->create($request->all());

            $response = [
                'message' => 'CompanyPosition created.',
                'data'    => $companyPosition->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyPosition = $this->companyPositionRepository->find($id);

        $companyPosition = $this->companyPositionTransformer->transform($companyPosition);

        return response()->json([
            'success' => true,
            'message' => 'Operação realizada !',
            'data' => $companyPosition
        ]);

        /*
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companyPosition,
            ]);
        }

        return view('companyPositions.show', compact('companyPosition'));
        */
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
        $companyPosition = $this->companyPositionRepository->find($id);

        return view('companyPositions.edit', compact('companyPosition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyPositionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CompanyPositionUpdateRequest $request, $id)
    {
        try {

            $this->companyPositionValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $companyPosition = $this->companyPositionRepository->update($request->all(), $id);

            $response = [
                'message' => 'CompanyPosition updated.',
                'data'    => $companyPosition->toArray(),
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
        $deleted = $this->companyPositionRepository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'CompanyPosition deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CompanyPosition deleted.');
    }
}
