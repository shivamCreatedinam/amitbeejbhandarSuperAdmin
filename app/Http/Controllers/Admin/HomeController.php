<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $data['total_orders'] = Lead::count();
        $data['total_pending_orders'] = Lead::where("order_status","pending")->count();
        $data['total_cancelled_orders'] = Lead::where("order_status","cancel")->count();
        $data['total_accept_orders'] = Lead::where("order_status","accept")->count();
        return view("dashboard", $data);
    }

    public function printHeaders(Request $request)
    {
        $headers = $request->headers->all();
        dd($request->ip());
    }
}
