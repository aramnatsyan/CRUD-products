<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsAndCategoriesRequest;
use App\Http\Requests\UpdateProductsAndCategoriesRequest;
use App\Models\ProductsAndCategories;

class ProductsAndCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreProductsAndCategoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductsAndCategoriesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductsAndCategories  $productsAndCategories
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsAndCategories $productsAndCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductsAndCategories  $productsAndCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductsAndCategories $productsAndCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsAndCategoriesRequest  $request
     * @param  \App\Models\ProductsAndCategories  $productsAndCategories
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductsAndCategoriesRequest $request, ProductsAndCategories $productsAndCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsAndCategories  $productsAndCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsAndCategories $productsAndCategories)
    {
        //
    }
}
