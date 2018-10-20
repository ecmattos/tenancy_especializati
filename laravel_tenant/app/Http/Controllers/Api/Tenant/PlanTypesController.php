<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PlanTypeCreateRequest;
use App\Http\Requests\PlanTypeUpdateRequest;
use App\Repositories\PlanTypeRepository;
use App\Validators\PlanTypeValidator;

/**
 * Class PlanTypesController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class PlanTypesController extends Controller
{
    /**
     * @var PlanTypeRepository
     */
    protected $repository;

    /**
     * @var PlanTypeValidator
     */
    protected $validator;

    /**
     * PlanTypesController constructor.
     *
     * @param PlanTypeRepository $repository
     * @param PlanTypeValidator $validator
     */
    public function __construct(PlanTypeRepository $repository, PlanTypeValidator $validator)
    {
        $this->repository = $repository;
        $this->repository = skipPresenter(true);
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $planTypes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $planTypes,
            ]);
        }

        return view('planTypes.index', compact('planTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlanTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PlanTypeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $planType = $this->repository->create($request->all());

            $response = [
                'message' => 'PlanType created.',
                'data'    => $planType->toArray(),
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
        $planType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $planType,
            ]);
        }

        return view('planTypes.show', compact('planType'));
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
        $planType = $this->repository->find($id);

        return view('planTypes.edit', compact('planType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlanTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PlanTypeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $planType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PlanType updated.',
                'data'    => $planType->toArray(),
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
                'message' => 'PlanType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PlanType deleted.');
    }
}
