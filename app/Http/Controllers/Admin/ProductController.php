<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Traits\ImageUploadTrait;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $data['products'] = Product::latest()->get();
        return view('products.index', $data);
    }

    public function addForm()
    {
        $data['categories'] = Category::orderBy("category_name", "ASC")->get();
        $data['sub_categories'] = SubCategory::orderBy("subcategory_name", "ASC")->get();
        $data['brands'] = Brand::orderBy("brand_name", "ASC")->get();
        return view('products.add', $data);
    }

    public function getSubCat($cat_id)
    {
        try {
            $sub_cats = SubCategory::where("category_id", $cat_id)->get();
            $data = "";
            foreach ($sub_cats as $sub_cat) {
                $data .= "<option value='{$sub_cat->id}'>{$sub_cat->subcategory_name}</option>";
            }
            return response()->json(["status" => true, "data" => $data, "message" => "Sub Category fetched", "status_code" => 200]);
        } catch (Exception $e) {
            return response()->json(["status" => false, "message" => $e->getMessage(), "status_code" => 500]);
        }
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                "category_name" => "required|exists:categories,id",
                "sub_category_name" => "required|exists:sub_categories,id",
                "brand_name" => "required|exists:brands,id",

                "product_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048",
                "product_name" => "required",
                "technical_name"=>"required",
                // "total_stock" => "required",
                // "mrp" => "required",
                // "selling_price" => "required",
                // "discount" => "required",
                "short_desc" => "nullable",
                "long_desc" => "nullable",
                "features" => "nullable",
            ]);

            $product_image = null;
            $path = "product_image";
            if ($request->hasFile("product_image")) {
                // if (!is_null($user->icon)) {
                //     $this->deleteImage($user->icon);
                // }
                $product_image = $this->uploadImage($request->file('product_image'), $path);
            }

           $product =  Product::create([
                "category_id" => $request->category_name,
                "sub_category_id" => $request->sub_category_name,
                "brand_id" => $request->brand_name,
                "image" => $product_image,             // Product image
                "product_name" => $request->product_name,       // Product name
                "technical_name" => $request->technical_name, 
                // "total_stock" => $request->total_stock,         // Total stock
                // "mrp" => $request->mrp,                         // Maximum retail price
                // "selling_price" => $request->selling_price,     // Selling price
                // "discount" => $request->discount,               // Discount
                "short_desc" => $request->short_desc,           // Short description
                "long_desc" => $request->long_desc,             // Long description
                "features" => $request->features,               // Features
            ]);
            // return redirect()->route('admin_product_list')->with('success', "Product Successfully Added.");

            return redirect()->route('variant_addForm',$product->id)->with('success', "Product Successfully Added.");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);  // Find the product or throw an exception if not found

            // You can also load any related data like categories, subcategories, brands for dropdowns
            $categories = Category::all();
            $subCategories = SubCategory::all();
            $brands = Brand::all();

            return view('products.edit', compact('product', 'categories', 'subCategories', 'brands'));  // Return the product and other related data to the view
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming data
            $request->validate([
                "category_name" => "required|exists:categories,id",
                "sub_category_name" => "required|exists:sub_categories,id",
                "brand_name" => "required|exists:brands,id",
                "product_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048",
                "product_name" => "required",
                "technical_name"=>"required",
                "short_desc" => "nullable",
                "long_desc" => "nullable",
                "features" => "nullable",
            ]);

            $product = Product::findOrFail($id);  // Fetch the product to be updated

            // Handle image update if a new file is uploaded
            $product_image = $product->image;  // Keep the old image by default
            $path = "product_image";
            
            if ($request->hasFile("product_image")) {
                // Optionally delete the old image if a new one is uploaded
                if ($product_image) {
                    $this->deleteImage($product_image);  // Assuming deleteImage is a helper function
                }
                $product_image = $this->uploadImage($request->file('product_image'), $path);
            }

            // Update the product record with the new data
            $product->update([
                "category_id" => $request->category_name,
                "sub_category_id" => $request->sub_category_name,
                "brand_id" => $request->brand_name,
                "image" => $product_image,               // Update image if a new one is uploaded
                "product_name" => $request->product_name,
                "technical_name" => $request->technical_name,     
                "short_desc" => $request->short_desc,
                "long_desc" => $request->long_desc,
                "features" => $request->features,
            ]);

            return redirect()->route('admin_product_list')->with('success', "Product Successfully Updated.");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function delete($id)
    {
        $product = Product::find($id);

        if (!is_null($product->image)) {
            $this->deleteImage($product->image);
        }
        $product->delete();
        return redirect()->back()->with('success', "Product Deleted.");
    }
}
