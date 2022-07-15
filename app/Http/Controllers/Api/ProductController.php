<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsAndCategories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as ResponseAlias;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $productList = Product::all();

        if (!$productList) {
            return response()->json([
                'status' => true,
                'message' => 'Product Categories list is empty',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => $productList,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validateProduct = Validator::make($request->all(),
            [
                'name' => 'required|string',
                'category_id' => 'required|integer',
                'price' => 'required|integer',
            ]);

        if ($validateProduct->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateProduct->errors()
            ], 401);
        }

        if ($category = ProductCategory::find($request->category_id)) {

            $product = new Product();

            foreach ($request->all() as $key => $val) {
                $product->$key = $val;
            }

            $product->category_name = $category->name;

            if ($product->save()) {
                return response()->json([
                    'status' => true,
                    'response' => $product->id,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'response' => 'Something went wrong',
                ], 500);
            }

        } else {
            return response()->json([
                'status' => false,
                'response' => 'Category not found',
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'response' => $product,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validateProduct = Validator::make($request->all(),
            [
                'name' => 'required|string',
                'category_id' => 'required|integer',
                'price' => 'required|integer',
                'is_published' => 'required|boolean',
            ]);

        if ($validateProduct->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateProduct->errors()
            ], 401);
        }

        if ($category = ProductCategory::find($request->category_id)) {

            $product = Product::find($id);

            if (!is_null($product)) {
                foreach ($request->all() as $key => $val) {
                    $product->$key = $val;
                }

                $product->save();

                return response()->json([
                    'status' => true,
                    'response' => $product,
                    'message' => 'Product successfully updated',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found',
                ], 404);
            }

        } else {
            return response()->json([
                'status' => false,
                'response' => 'Category not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return ResponseAlias
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->is_deleted = true;

        if (is_numeric($id)) {
            if ($product->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Product successfully deleted',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not deleted, Please try again letter.',
                ], 404);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid parameter',
            ], 404);
        }
    }
}
