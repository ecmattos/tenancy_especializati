<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TrashCreateRequest;
use App\Http\Requests\TrashUpdateRequest;
use App\Repositories\TrashRepository;
use App\Validators\TrashValidator;

/**
 * Class TrashesController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class TrashesController extends Controller
{
    /**
     * @var TrashRepository
     */
    protected $repository;

    /**
     * @var TrashValidator
     */
    protected $validator;

    /**
     * TrashesController constructor.
     *
     * @param TrashRepository $repository
     * @param TrashValidator $validator
     */
    public function __construct(TrashRepository $repository, TrashValidator $validator)
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
        $trashes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $trashes,
            ]);
        }

        return view('trashes.index', compact('trashes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TrashCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TrashCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $trash = $this->repository->create($request->all());

            $response = [
                'message' => 'Trash created.',
                'data'    => $trash->toArray(),
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
        $trash = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $trash,
            ]);
        }

        return view('trashes.show', compact('trash'));
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
        $trash = $this->repository->find($id);

        return view('trashes.edit', compact('trash'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TrashUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TrashUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $trash = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Trash updated.',
                'data'    => $trash->toArray(),
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
                'message' => 'Trash deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Trash deleted.');
    }
}
