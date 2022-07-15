<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $productCategoryList = ProductCategory::all();

        if (!$productCategoryList) {
            return response()->json([
                'status' => true,
                'message' => 'Product Categories list is empty',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => $productCategoryList,
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
        $validateProductCategory = Validator::make($request->all(),
            [
                'name' => 'required|string|regex:/(^[A-Za-z0-9_]+$)+/',
            ]);

        if ($validateProductCategory->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateProductCategory->errors()
            ], 401);
        }

        $productCategory = new ProductCategory();

        foreach ($request->all() as $key => $val) {
            $productCategory->$key = $val;
        }

        $productCategory->save();

        return response()->json([
            'status' => true,
            'response' => $productCategory->id,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $productCategory = ProductCategory::find($id);

        if (!$productCategory) {
            return response()->json([
                'status' => false,
                'message' => 'ProductCategory not found',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'response' => $productCategory,
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
        $validateProductCategory = Validator::make($request->all(),
            [
                'lbl_key' => 'required|string|regex:/(^[A-Za-z0-9_]+$)+/',
            ]);

        if ($validateProductCategory->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateProductCategory->errors()
            ], 401);
        }

        $productCategory = ProductCategory::find($id);

        if (!is_null($productCategory)) {
            foreach ($request->all() as $key => $val) {
                $productCategory->$key = $val;
            }

            $productCategory->save();

            return response()->json([
                'status' => true,
                'response' => $productCategory,
                'message' => 'ProductCategory successfully updated',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'ProductCategory not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (is_numeric($id)) {
            $productWithThisCategory = Product::where('category_id', '=', $id)->get();
            if (!empty($productWithThisCategory->all())) {
                return response()->json([
                    'status' => false,
                    'message' => 'There is some Products with this category. You can not delete this category',
                ], 404);
            } else {
                if (ProductCategory::destroy($id)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'ProductCategory successfully deleted',
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'ProductCategory not deleted, Please try again letter.',
                    ], 404);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid parameter',
            ], 404);
        }
    }
}