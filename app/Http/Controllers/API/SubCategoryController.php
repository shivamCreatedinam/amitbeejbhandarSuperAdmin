<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Get(
     *     path="/sub-category-list/{category_id}",
     *     operationId="getSubCategoryList",
     *     tags={"SubCategory"},
     *     summary="Get the list of sub-categories for a given category",
     *     description="Returns a list of sub-categories filtered by category_id",
     *     @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to fetch the sub-categories for",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sub Category successfully fetched.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sub Category not found."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error: Something went wrong."
     *     )
     * )
     */

    public function getSubCategory($category_id)
    {
        try {
            $sub_category = SubCategory::where('category_id', $category_id)->get(['id', 'category_id', 'subcategory_name']);
            return $this->successResponse($sub_category, "Sub Category successfully fetched.");
        } catch (Exception $e) {
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
}
