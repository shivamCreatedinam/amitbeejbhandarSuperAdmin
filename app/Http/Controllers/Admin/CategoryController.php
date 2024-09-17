<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::latest()->get();
        return view('category.index', $data);
    }

    public function addForm()
    {
        return view('category.add');
    }

    public function store(Request $request){
        $request->validate([
            "category_name"=>"required|string",
        ]);


        try{
            Category::create([
                "category_name"=>$request->category_name
            ]);
            return redirect()->route('admin_category_list')->with('success',"Category Successfully Added.");
        }
        catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        return redirect()->back()->with('success',"Category Deleted.");
    }
}
