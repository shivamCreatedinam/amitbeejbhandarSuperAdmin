<?php

namespace App\Http\Controllers\API;

use App\Events\OrderCreateEvent;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Setting;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request) {}


    /**
     * @OA\Post(
     *     path="/create-lead",
     *     tags={"Lead"},
     *     summary="Create a new lead",
     *     description="This endpoint creates a new lead with the provided data.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name", "email", "mobile"},
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *                 @OA\Property(property="mobile", type="string", example="9876543210", description="10-digit mobile number"),
     * @OA\Property(property="quotes", type="string", example="send array", description="optional array of quotes"),
     *                 @OA\Property(property="gst_number", type="string", nullable=true, example="22AAAAA0000A1Z5"),
     *    *                 @OA\Property(property="pan_number", type="string", nullable=true, example="ABCDE1234F"),
     *                 @OA\Property(property="remarks", type="string", nullable=true, example="Customer prefers evening calls"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Leads successfully created.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="mobile", type="string", example="9876543210"),
     *             @OA\Property(property="quotes", type="string", example="['Sample Quote 1', 'Sample Quote 2']"),
     *             @OA\Property(property="gst_number", type="string", nullable=true, example="22AAAAA0000A1Z5"),
     *  *             @OA\Property(property="pan_number", type="string", nullable=true, example="ABCDE1234F"),
     *             @OA\Property(property="remarks", type="string", nullable=true, example="Customer prefers evening calls"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Validation Error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error: {message}",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Error: Database connection failed")
     *         )
     *     )
     * )
     */

    public function saveLeadData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|min:10|max:10',
            'quotes' => 'nullable',
            'gst_number' => 'nullable',
            'pan_number' => 'nullable',
            'remarks' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $lead = Lead::create([
                "name" => $request->name,
                "email" => $request->email,
                "mobile" => $request->mobile,
                "quotes" => json_encode($request->quotes, true),
                "gst_number" => $request->gst_number,
                "pan_number" => $request->pan_number,
                "remarks" => $request->remarks,
            ]);

            // Adding best seller 
            $quotes = $request->quotes ? json_decode($request->quotes, true) : [];

            // Check if decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                 return $this->errorResponse("Invalid quotes JSON format: " . json_last_error_msg());
            }
 
            // Ensure quotes is an array
            if (!is_array($quotes)) {
                 return $this->errorResponse("Quotes must be an array.");
            }
 
            // Loop through each quote to update the best_seller count
            foreach ($quotes as $quote) {
                 $productId = $quote['id']; // Get the product ID
 
                 // Check if the product exists in the products table
                 $product = Product::find($productId);
                 if ($product) {
                     // Increment the best_seller count
                     $product->increment('best_seller');
                 }
            }

            $setting_mail = Setting::query()->first();
            event(new OrderCreateEvent($lead, $setting_mail));
            DB::commit();
            return $this->successResponse($lead, "Leads successfully created.");
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel("lead")->error("Lead Error : " .  $e->getMessage());
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
}
