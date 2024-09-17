<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data['sub_categories'] = SubCategory::latest()->get();
        return view('subcategory.index', $data);
    }

    public function addForm()
    {
        $data['categories'] = Category::orderBy("category_name","ASC")->get();
        return view('subcategory.add',$data);
    }

    public function store(Request $request){
        $request->validate([
            "category_name"=>"required|exists:categories,id",
            "subcategory_name"=>"required|string",
        ]);


        try{
            SubCategory::create([
                "category_id"=>$request->category_name,
                "subcategory_name"=>$request->subcategory_name
            ]);
            return redirect()->route('admin_sub_category_list')->with('success',"Sub Category Successfully Added.");
        }
        catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function delete($id)
    {
        SubCategory::find($id)->delete();
        return redirect()->back()->with('success',"Sub Category Deleted.");
    }
}
