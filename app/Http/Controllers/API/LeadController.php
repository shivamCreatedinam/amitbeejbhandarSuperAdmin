<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
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
                "remarks" => $request->remarks,
            ]);
            DB::commit();
            return $this->successResponse($lead, "Leads successfully created.");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse("Error: " . $e->getMessage());
        }
    }
}
