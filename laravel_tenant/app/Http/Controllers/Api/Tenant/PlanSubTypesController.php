<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PlanSubTypeCreateRequest;
use App\Http\Requests\PlanSubTypeUpdateRequest;
use App\Repositories\PlanSubTypeRepository;
use App\Validators\PlanSubTypeValidator;

/**
 * Class PlanSubTypesController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class PlanSubTypesController extends Controller
{
    /**
     * @var PlanSubTypeRepository
     */
    protected $repository;

    /**
     * @var PlanSubTypeValidator
     */
    protected $validator;

    /**
     * PlanSubTypesController constructor.
     *
     * @param PlanSubTypeRepository $repository
     * @param PlanSubTypeValidator $validator
     */
    public function __construct(PlanSubTypeRepository $repository, PlanSubTypeValidator $validator)
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
        $planSubTypes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $planSubTypes,
            ]);
        }

        return view('planSubTypes.index', compact('planSubTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlanSubTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PlanSubTypeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $planSubType = $this->repository->create($request->all());

            $response = [
                'message' => 'PlanSubType created.',
                'data'    => $planSubType->toArray(),
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
        $planSubType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $planSubType,
            ]);
        }

        return view('planSubTypes.show', compact('planSubType'));
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
        $planSubType = $this->repository->find($id);

        return view('planSubTypes.edit', compact('planSubType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlanSubTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PlanSubTypeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $planSubType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PlanSubType updated.',
                'data'    => $planSubType->toArray(),
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
                'message' => 'PlanSubType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PlanSubType deleted.');
    }
}
