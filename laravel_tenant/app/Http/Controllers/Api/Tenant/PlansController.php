<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PlanCreateRequest;
use App\Http\Requests\PlanUpdateRequest;
use App\Repositories\PlanRepository;
use App\Validators\PlanValidator;

/**
 * Class PlansController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class PlansController extends Controller
{
    /**
     * @var PlanRepository
     */
    protected $repository;

    /**
     * @var PlanValidator
     */
    protected $validator;

    /**
     * PlansController constructor.
     *
     * @param PlanRepository $repository
     * @param PlanValidator $validator
     */
    public function __construct(PlanRepository $repository, PlanValidator $validator)
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
        $plans = $this->repository->skipPresenter(false)->all();

        return response()->json([
            'success' => true,
            'message' => 'Operação realizada !',
            'plans' => $plans
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlanCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PlanCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $plan = $this->repository->create($request->all());

            $response = [
                'message' => 'Plan created.',
                'data'    => $plan->toArray(),
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
        $plan = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $plan,
            ]);
        }

        return view('plans.show', compact('plan'));
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
        $plan = $this->repository->find($id);

        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlanUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PlanUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $plan = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Plan updated.',
                'data'    => $plan->toArray(),
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
                'message' => 'Plan deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Plan deleted.');
    }
}
