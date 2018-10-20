<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MaterialUnitCreateRequest;
use App\Http\Requests\MaterialUnitUpdateRequest;
use App\Repositories\MaterialUnitRepository;
use App\Validators\MaterialUnitValidator;
use App\Transformers\MaterialUnitTransformer;

/**
 * Class MaterialUnitsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class MaterialUnitsController extends Controller
{
    /**
     * @var MaterialUnitRepository
     */
    protected $materialUnitRepository;

    /**
     * @var MaterialUnitValidator
     */
    protected $materialUnitValidator;

    /**
     * @var MaterialUnitTransformer
     */
    protected $materialUnitTransformer;

    /**
     * MaterialUnitsController constructor.
     *
     * @param MaterialUnitRepository $materialUnitRepository
     * @param MaterialUnitValidator $materialUnitValidator
     * @param MaterialUnitTransformer $materialUnitTransformer
     */
    public function __construct(MaterialUnitRepository $materialUnitRepository, MaterialUnitValidator $materialUnitValidator, MaterialUnitTransformer $materialUnitTransformer)
    {
        $this->materialUnitRepository = $materialUnitRepository;
        $this->materialUnitRepository->skipPresenter(true);

        $this->materialUnitValidator  = $materialUnitValidator;
        $this->materialUnitTransformer  = $materialUnitTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->materialUnitRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $materialUnits = $this->materialUnitRepository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $materialUnits,
            ]);
        }

        return view('materialUnits.index', compact('materialUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialUnitCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MaterialUnitCreateRequest $request)
    {
        try {

            $this->materialUnitValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $materialUnit = $this->materialUnitRepository->create($request->all());

            $response = [
                'message' => 'MaterialUnit created.',
                'data'    => $materialUnit->toArray(),
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
        $materialUnit = $this->materialUnitRepository->find($id);

        $materialUnit = $this->materialUnitTransformer->transform($materialUnit);

        return response()->json([
            'success' => true,
            'message' => 'Operação realizada !',
            'data' => $materialUnit
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
        $materialUnit = $this->materialUnitRepository->find($id);

        return view('materialUnits.edit', compact('materialUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MaterialUnitUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MaterialUnitUpdateRequest $request, $id)
    {
        try {

            $this->materialUnitValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $materialUnit = $this->materialUnitRepository->update($request->all(), $id);

            $response = [
                'message' => 'MaterialUnit updated.',
                'data'    => $materialUnit->toArray(),
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
        $deleted = $this->materialUnitRepository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'MaterialUnit deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MaterialUnit deleted.');
    }
}
