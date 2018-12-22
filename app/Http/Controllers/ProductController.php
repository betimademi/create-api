<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
//API:  for POST, DELETE, PUT | PATCH we need authentication  we create new constructor  middleware name of middleware is auth:api exept index and show

        public function __construct()
        {
            $this -> middleware('auth:api')->except('index','show');
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //
        return  ProductCollection::collection(Product::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        //
        $product = new Product;
        $product->name = $request -> name;
        $product->detail = $request -> description;
        $product->stock = $request -> stock;
        $product->price = $request -> price;
        $product->discount = $request -> discount;

        $product->save();

        return response([

            'data' => new ProductResource($product)

        ],Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        //
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Product $product
     * @return \Illuminate\Http\Response
     * @throws ProductNotBelongsToUser
     */
    public function update(Request $request, Product $product)
    {
        // we firstly need to check if the product belongs to particular user
        $this->ProductUserCheck($product);

        $request['detail'] = $request->description;

        unset($request['description']);

        $product->update($request->all());

        return response([

            'data' => new ProductResource($product)

        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        //
        $this ->ProductUserCheck($product);
        $product->delete();

        return response(null,Response::HTTP_NO_CONTENT);
    }

    public function ProductUserCheck($product){

        if(Auth::id() !== $product->user_id)
        {

            throw new ProductNotBelongsToUser;
        }

    }
}
