<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Get(
     *     path="/category-list",
     *     operationId="getCategoryList",
     *     tags={"Category"},
     *     summary="Get the list of categories",
     *     description="Returns a list of categories with id and category_name",
     *     @OA\Response(
     *         response=200,
     *         description="Category successfully fetched.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error: Something went wrong."
     *     )
     * )
     */
    public function getCategory()
    {
        try {
            $category = Category::get(['id', 'category_name']);
            return $this->successResponse($category, "Category successfully fetched.");
        } catch (Exception $e) {
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
}
