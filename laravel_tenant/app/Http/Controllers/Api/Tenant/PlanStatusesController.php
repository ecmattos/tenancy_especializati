<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PlanStatusCreateRequest;
use App\Http\Requests\PlanStatusUpdateRequest;
use App\Repositories\PlanStatusRepository;
use App\Validators\PlanStatusValidator;

/**
 * Class PlanStatusesController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class PlanStatusesController extends Controller
{
    /**
     * @var PlanStatusRepository
     */
    protected $repository;

    /**
     * @var PlanStatusValidator
     */
    protected $validator;

    /**
     * PlanStatusesController constructor.
     *
     * @param PlanStatusRepository $repository
     * @param PlanStatusValidator $validator
     */
    public function __construct(PlanStatusRepository $repository, PlanStatusValidator $validator)
    {
        $this->repository = $repository;
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
        $planStatuses = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $planStatuses,
            ]);
        }

        return view('planStatuses.index', compact('planStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlanStatusCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PlanStatusCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $planStatus = $this->repository->create($request->all());

            $response = [
                'message' => 'PlanStatus created.',
                'data'    => $planStatus->toArray(),
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
        $planStatus = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $planStatus,
            ]);
        }

        return view('planStatuses.show', compact('planStatus'));
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
        $planStatus = $this->repository->find($id);

        return view('planStatuses.edit', compact('planStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlanStatusUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PlanStatusUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $planStatus = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PlanStatus updated.',
                'data'    => $planStatus->toArray(),
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
                'message' => 'PlanStatus deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PlanStatus deleted.');
    }
}
