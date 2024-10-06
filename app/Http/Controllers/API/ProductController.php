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
 *                 ),
 *                   @OA\Property(
 *                     property="page_no",
 *                     type="integer",
 *                     description="Number of Page.",
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
            'page_no' => 'nullable|numeric',  // Page number
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
                $products->where(function($q) use ($query) {
                    $q->where('product_name', 'like', '%' . $query . '%')
                    ->orWhere('technical_name', 'like', '%' . $query . '%')
                    ->orWhere('short_desc', 'like', '%' . $query . '%');
                });
            }
    
            // Sort products by best_seller count in descending order
            $products->orderBy('best_seller', 'desc');
    
            // Get the per_page_item and page_no, set defaults if not provided
            $perPage = $request->input('per_page_item', 10);  // Default items per page to 10
            $pageNo = $request->input('page_no', 1);  // Default page to 1
    
            // Set the current page manually
            \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($pageNo) {
                return $pageNo;
            });
    
            // Use pagination
            $paginatedProducts = $products->paginate($perPage);
            
            $base_url = url('/public/storage');
    
            // Prepare response data
            $response = [
                'data' => [
                    'data' => $paginatedProducts->items(),
                    'total' => $paginatedProducts->total(),
                    'current_page' => $paginatedProducts->currentPage(),
                    'per_page' => $paginatedProducts->perPage(),
                    'last_page' => $paginatedProducts->lastPage(),
                    'next_page_url' => $paginatedProducts->nextPageUrl(),
                    'prev_page_url' => $paginatedProducts->previousPageUrl(),
                ],
                'base_url' => $base_url,
                'per_page_item' => $perPage,
                'page' => $pageNo,
            ];
    
            // Return success response with paginated products
            return $this->successResponse($response, "Products successfully fetched.");
        } catch (Exception $e) {
            // Return error response if an exception occurs
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
 

}
