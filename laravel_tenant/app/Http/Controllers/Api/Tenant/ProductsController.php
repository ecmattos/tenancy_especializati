<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Validators\ProductSearchValidator;
use App\Validators\ProductValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

#use JWTAuth;

/**
 * Class ProductsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class ProductsController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var ProductSearchValidator
     */
    protected $productSearchValidator;

        /**
     * @var ProductValidator
     */
    protected $productValidator;

    /**
     * ProductsController constructor.
     *
     * @param ProductRepository $productRepository
     * @param ProductSearchValidator $productSearchValidator
     * @param ProductValidator $productValidator
     */
    public function __construct(ProductRepository $productRepository, ProductSearchValidator $productSearchValidator, ProductValidator $productValidator)
    {
        $this->productRepository = $productRepository;
        $this->productSearchValidator  = $productSearchValidator;
        $this->productValidator  = $productValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$this->productRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $products = $this->productRepository->all();

        return response()->json([
            'success' => true,
            'message' => 'Operação realizada !',
            'data' => $products
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
            $this->productSearchValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $srch_product_terms = $input['description_terms'];
            
            $products = $this->productRepository->productsSearchDescription($srch_product_terms);

            return response()->json([
                'success'  => true,
                'products' => $products, 
                'messages' => 'Operação realizada com sucesso!'
            ]);

        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success'  => false,
                    'error' => $e->getMessageBag()
                ], 401);
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
            $this->productSearchValidator->with($request->all())->passesOrFail();

            $srch_product_terms = $input['params'];

            $product = $this->productRepository->productsSearchCode($srch_product_terms);
            #$product = $this->productRepository->skipCriteria()->findByField('code', $srch_product_terms);
            #$product = $this->productRepository->findWhere(['code'=>$srch_product_terms,'code'=>$srch_product_terms])->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Operação realizada !',
                'product' => $product
            ]);
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
     * Store a newly created resource in storage.
     *
     * @param  ProductCreateRequest $request
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
            $this->productValidator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $product = $this->productRepository->create($input);

            return response()->json([
                'success' => true,
                'product' => $product, 
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
        $product = $this->productRepository->find($id);

        return response()->json([
            'success' => true,
            'product' => $product, 
            'messages' => 'Operação realizada com sucesso!'
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
        $product = $this->productRepository->find($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        try {

            $this->productValidator->with($request->all())->passesOrFail();

            $product = $this->productRepository->update($request->all(), $id);

            $response = [
                'message' => 'Product updated.',
                'data'    => $product->toArray(),
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
        $deleted = $this->productRepository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Product deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Product deleted.');
    }
}
