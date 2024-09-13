<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Get(
     *     path="/brand-list",
     *     operationId="getBrandList",
     *     tags={"Brand"},
     *     summary="Get the list of brands",
     *     description="Returns a list of brands with their ids and brand names.",
     *     @OA\Response(
     *         response=200,
     *         description="Brand successfully fetched.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error: Something went wrong."
     *     )
     * )
     */

    public function getBrand()
    {
        try {
            $brand = Brand::get(['id', 'brand_name']);
            return $this->successResponse($brand, "Brand successfully fetched.");
        } catch (Exception $e) {
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
}
