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
        // $request->validate([
        //     "category_name" => "required|exists:categories,id",
        //     "subcategory_name" => "required|exists:sub_categories,id",
        //     "brand_name" => "required|exists:brands,id",

        //     "product_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048",
        //     "product_name" => "required",
        //     "total_stock" => "required",
        //     "mrp" => "required",
        //     "selling_price" => "required",
        //     "discount" => "required",
        //     "short_desc" => "nullable",
        //     "long_desc" => "nullable",
        //     "features" => "nullable",
        // ]);

        try {

            $request->validate([
                "category_name" => "required|exists:categories,id",
                "sub_category_name" => "required|exists:sub_categories,id",
                "brand_name" => "required|exists:brands,id",

                "product_image" => "nullable|mimes:jpeg,jpg,png,svg|max:2048",
                "product_name" => "required",
                "total_stock" => "required",
                "mrp" => "required",
                "selling_price" => "required",
                "discount" => "required",
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

            Product::create([
                "category_id" => $request->category_name,
                "sub_category_id" => $request->sub_category_name,
                "brand_id" => $request->brand_name,
                "image" => $product_image,             // Product image
                "product_name" => $request->product_name,       // Product name
                "total_stock" => $request->total_stock,         // Total stock
                "mrp" => $request->mrp,                         // Maximum retail price
                "selling_price" => $request->selling_price,     // Selling price
                "discount" => $request->discount,               // Discount
                "short_desc" => $request->short_desc,           // Short description
                "long_desc" => $request->long_desc,             // Long description
                "features" => $request->features,               // Features
            ]);
            return redirect()->route('admin_product_list')->with('success', "Product Successfully Added.");
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
