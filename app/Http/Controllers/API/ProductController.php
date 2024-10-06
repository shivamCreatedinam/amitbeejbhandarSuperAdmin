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
 *                     property="price",
 *                     type="number",
 *                     format="float",
 *                     description="Filter products by price",
 *                     example=99.99,
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
            'price' => 'nullable|numeric',  // Price filter
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
    
            // Filter by selling_price from product_varient
            if ($request->filled('price')) {
                $price = $request->price;
                // Assuming product has a one-to-many relation with product_varient
                $products->whereHas('variants', function ($q) use ($price) {
                    $q->where('selling_price', '<=', $price);  // Adjust the operator as needed
                });
            }
    
            // Sort products by best_seller count in descending order
            $products->orderBy('best_seller', 'desc');
    
            // Check if pagination parameters are provided
            if ($request->filled('per_page_item') || $request->filled('page_no')) {
                // Use pagination if provided
                $perPage = $request->input('per_page_item', 10);  // Default items per page to 10
                $pageNo = $request->input('page_no', 1);  // Default page to 1
    
                // Set the current page manually
                \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($pageNo) {
                    return $pageNo;
                });
    
                // Use pagination
                $paginatedProducts = $products->paginate($perPage);
    
                // Prepare response with paginated data
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
                ];
            } else {
                
                // Get all products without pagination
                $allProducts = $products->get();
    
                // Prepare response with all products
                $response = [
                    'data' => [
                        'data' => $allProducts,
                        'total' => $allProducts->count(),
                        'current_page' => 1,
                        'per_page' => $allProducts->count(),
                        'last_page' => 1,
                    ],
                ];
                 $perPage = $allProducts->count() ;
                 $pageNo = 1;
            }
    
            // Base URL for product images or assets
            $base_url = url('/public/storage');
    
            // Add base URL to the response
            $response['base_url'] = $base_url;
            $response['per_page_item'] = $perPage;
            $response['page'] = $pageNo;
    
            // Return success response with products data
            return $this->successResponse($response, "Products successfully fetched.");
        } catch (Exception $e) {
            // Return error response if an exception occurs
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
   
 
}
