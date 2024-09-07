<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $data["setting"] = Setting::query()->first();
        return view('setting.index', $data);
    }

    public function settingUpdate(Request $request)
    {

        $request->validate([
            "id" => "required|exists:settings,id",
            "website_name" => "required",
            "from_mail_name" => "required",
            "from_mail_address" => "required",
        ]);

        DB::beginTransaction();
        try {
            Setting::updateOrCreate(
                ['id' => $request->id],
                [
                    'website_name' => $request->website_name,
                    'from_mail_name' => $request->from_mail_name,
                    'from_mail_address' => $request->from_mail_address,
                ]
            );
            DB::commit();
            return redirect()->back()->with('success', "Setting Updated Successfully..");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
