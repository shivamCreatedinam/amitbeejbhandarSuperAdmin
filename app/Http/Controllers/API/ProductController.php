<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiResponseTrait;

    /**
 * @OA\Post(
 *     path="/products",
 *     operationId="getProductList",
 *     tags={"Product"},
 *     summary="Get a list of products with optional filters and pagination",
 *     description="Returns a list of products filtered by brand_id, category_id, sub_category_id, or query, with optional pagination.",
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="brand_id",
 *                     type="integer",
 *                     description="Filter by Brand ID",
 *                     example=1,
 *                     nullable=true
 *                 ),
 *                 @OA\Property(
 *                     property="category_id",
 *                     type="integer",
 *                     description="Filter by Category ID",
 *                     example=1,
 *                     nullable=true
 *                 ),
 *                 @OA\Property(
 *                     property="sub_category_id",
 *                     type="integer",
 *                     description="Filter by Sub Category ID",
 *                     example=1,
 *                     nullable=true
 *                 ),
 *                 @OA\Property(
 *                     property="query",
 *                     type="string",
 *                     description="Search query for product name",
 *                     example="Admine",
 *                     nullable=true
 *                 ),
 *                 @OA\Property(
 *                     property="per_page_item",
 *                     type="integer",
 *                     description="Number of items per page for pagination",
 *                     example=10,
 *                     nullable=true
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Products successfully fetched.",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error: Something went wrong."
 *     )
 * )
 */
    public function getProduct(Request $request)
    {
        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'brand_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'sub_category_id' => 'nullable|numeric',
            'query' => 'nullable|string',  // Search query for product name
            'per_page_item' => 'nullable|numeric',  // Number of items per page
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->first());
        }

        try {
            // Build the product query
            $products = Product::query();

            // Apply filters if the values are provided and not zero
            if ($request->filled('brand_id') && $request->brand_id != 0) {
                $products->where('brand_id', $request->brand_id);
            }

            if ($request->filled('category_id') && $request->category_id != 0) {
                $products->where('category_id', $request->category_id);
            }

            if ($request->filled('sub_category_id') && $request->sub_category_id != 0) {
                $products->where('sub_category_id', $request->sub_category_id);
            }

            if ($request->filled('query')) {
                $query = trim($request['query']);
                $products->where('product_name', 'like', '%' . $query . '%')
                        ->orWhere('technical_name', 'like', '%' . $query . '%')
                        ->orWhere('short_desc', 'like', '%' . $query . '%');
            }
            

            // Sort products by best_seller count in descending order
            $products->orderBy('best_seller', 'desc');

            // Pagination: If 'per_page_item' is provided, paginate, otherwise use a default value
            $perPage = $request->per_page_item ?? 50;  // Default to 50 items per page if not provided
            $paginatedProducts = $products->paginate($perPage);

            $base_url = url('/public/storage');
            $paginatedProducts["base_url"] =  $base_url;
            
            // Return success response with paginated products
            return $this->successResponse($paginatedProducts, "Products successfully fetched.");
        } catch (Exception $e) {
            // Return error response if an exception occurs
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
}
