<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index($id)
    {
        $product_id = $id;
        $variants = ProductVariant::where('product_id', $product_id)->get();
        return view('products.variant.index', compact('variants', 'product_id'));
    }

    public function addForm($id)
    {
        $product_id = $id;
        return view('products.variant.add', compact('product_id'));
    }

    public function store(Request $request, $id)
    {
        try {
            // Validate incoming request data
            $request->validate([
                "variant_name" => "required|integer|min:1",   // Quantity should be an integer (e.g., "1", "10")
                "unit" => "required|string|max:50",           // Unit is required (ml, g, kg, etc.)
                "variant_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048",  // Optional image with validation
                "total_stock" => "required|integer|min:0",    // Total stock must be a non-negative integer
                "mrp" => "required|numeric|min:0",            // MRP must be a positive number
                "selling_price" => "required|numeric|min:0",  // Selling price must be a positive number
                "discount" => "required|numeric|min:0|max:100", // Discount must be between 0 and 100
            ]);

            // Handle the image upload
            $variant_image = null;
            $path = "variant_image";
            if ($request->hasFile("variant_image")) {
                $variant_image = $this->uploadImage($request->file('variant_image'), $path);
            }

            // Create a new product variant
            ProductVariant::create([
                "product_id" => $id,                           // Foreign key to the product
                "variant_name" => $request->variant_name,      // Quantity (e.g., "1", "10")
                "unit" => $request->unit,                      // Unit type (e.g., "ml", "kg")
                "image" => $variant_image,                     // Product image (if any)
                "total_stock" => $request->total_stock,        // Total stock
                "mrp" => $request->mrp,                        // Maximum retail price
                "selling_price" => $request->selling_price,    // Selling price
                "discount" => $request->discount,              // Discount percentage
            ]);

            // Redirect to the variant list with a success message
            return redirect()->route('product_variant_list', $id)->with('success', "Product Variant Successfully Added.");
        } catch (\Exception $e) {
            // Catch any exceptions and return with an error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function editForm(Request $request, $id)
    {
        try{
            $variant = ProductVariant::find($id);
            return view('products.variant.edit', compact('variant'));

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request data
            $request->validate([
                "variant_name" => "required|integer|min:1|unique:product_variants,variant_name," . $id, // Quantity as integer
                "unit" => "required|string|max:50", // Unit type is required
                "variant_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048", // Optional image with validation
                "total_stock" => "required|integer|min:0", // Total stock must be a non-negative integer
                "mrp" => "required|numeric|min:0", // MRP must be a positive number
                "selling_price" => "required|numeric|min:0", // Selling price must be a positive number
                "discount" => "required|numeric|min:0|max:100", // Discount must be between 0 and 100
            ]);

            // Find the variant to be updated
            $variant = ProductVariant::findOrFail($id);

            // Keep the old image if no new one is uploaded
            $variant_image = $variant->image; 
            $path = "variant_image";

            // Handle image update if provided
            if ($request->hasFile("variant_image")) {
                // Optionally, delete the old image if a new one is uploaded
                if ($variant_image) {
                    $this->deleteImage($variant_image); // Delete old image
                }
                $variant_image = $this->uploadImage($request->file('variant_image'), $path); // Upload new image
            }

            // Update the variant record with the new data
            $variant->update([
                "variant_name" => $request->variant_name, // Updated quantity
                "unit" => $request->unit, // Updated unit
                "image" => $variant_image, // Updated image if there's a new one
                "total_stock" => $request->total_stock, // Updated total stock
                "mrp" => $request->mrp, // Updated maximum retail price
                "selling_price" => $request->selling_price, // Updated selling price
                "discount" => $request->discount, // Updated discount
            ]);

            // Redirect to the variant list with a success message
            return redirect()->route('product_variant_list', $variant->product_id)->with('success', "Product Variant Successfully Updated.");
        } catch (\Exception $e) {
            // Catch any exceptions and return with an error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function destroy($id)
    {
        try {
            $variant = ProductVariant::findOrFail($id); 

            // Delete the associated image if it exists
            if ($variant->variant_image) {
                $this->deleteImage($variant->variant_image);  
            }
            $variant->delete();

            return redirect()->route('product_variant_list', $variant->product_id)->with('success', "Product Variant Successfully Deleted.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
