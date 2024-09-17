<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $data['brands'] = Brand::latest()->get();
        return view('brand.index', $data);
    }

    public function addForm()
    {
        return view('brand.add');
    }

    public function store(Request $request){
        $request->validate([
            "brand_name"=>"required|string",
        ]);


        try{
            Brand::create([
                "brand_name"=>$request->brand_name
            ]);
            return redirect()->route('admin_brand_list')->with('success',"Brand Successfully Added.");
        }
        catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function delete($id)
    {
        Brand::find($id)->delete();
        return redirect()->back()->with('success',"Brand Deleted.");
    }
}
