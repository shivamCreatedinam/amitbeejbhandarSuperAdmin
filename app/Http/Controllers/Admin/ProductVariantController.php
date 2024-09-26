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
            $request->validate([
                "variant_name" => "required|unique:product_variants,variant_name",
                "variant_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048",
                "total_stock" => "required",
                "mrp" => "required",
                "selling_price" => "required",
                "discount" => "required",
            ]);

            $variant_image = null;
            $path = "variant_image";
            if ($request->hasFile("variant_image")) {
             
                $variant_image = $this->uploadImage($request->file('variant_image'), $path);
            }

            ProductVariant::create([
                "product_id" =>$id,
                "variant_name" => $request->variant_name,
                // "image" => $varient_image,             // Product image
                "total_stock" => $request->total_stock,         // Total stock
                "mrp" => $request->mrp,                         // Maximum retail price
                "selling_price" => $request->selling_price,     // Selling price
                "discount" => $request->discount,               // Discount
            ]);
            return redirect()->route('product_variant_list',$id)->with('success', "Product Successfully Added.");
        } catch (\Exception $e) {
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
            $request->validate([
                "variant_name" => "required|unique:product_variants,variant_name," . $id,
                "variant_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048",
                "total_stock" => "required",
                "mrp" => "required",
                "selling_price" => "required",
                "discount" => "required",
            ]);

            $variant = ProductVariant::findOrFail($id);  

            // Handle image update if provided
            $variant_image = $variant->variant_image;  // Keep the old image if no new one is uploaded
            $path = "variant_image";
            
            if ($request->hasFile("variant_image")) {
                // Optionally, delete the old image if a new one is uploaded
                if ($variant_image) {
                    $this->deleteImage($variant_image);
                }
                $variant_image = $this->uploadImage($request->file('variant_image'), $path);
            }

            // Update the variant record with the new data
            $variant->update([
                "variant_name" => $request->variant_name,
                "variant_image" => $variant_image,         // Update image if there's a new one
                "total_stock" => $request->total_stock,
                "mrp" => $request->mrp,
                "selling_price" => $request->selling_price,
                "discount" => $request->discount,
            ]);

            return redirect()->route('product_variant_list', $variant->product_id)->with('success', "Product Successfully Updated.");
        } catch (\Exception $e) {
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
