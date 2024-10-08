<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusEvent;
use App\Http\Controllers\Controller;
use App\Mail\SendQuoteMail;
use App\Models\Lead;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Page Length
            $pageNumber = ($request->start / $request->length) + 1;
            $pageLength = $request->length;
            $skip = ($pageNumber - 1) * $pageLength;
            $search = $request->search['value'];
            // $order = $request->order[0]['column'];
            $dir = $request->order[0]['dir'] ?? "desc";
            // $column = $request->columns[$order]['data'];

            $leads = Lead::query()->orderBy('created_at', $dir);

            if ($search) {
                $leads->where(function ($q) use ($search) {
                    $q->orWhere('name', 'like', '%' . $search . '%');
                    $q->orWhere('email', 'like', '%' . $search . '%');
                    $q->orWhere('mobile', 'like', '%' . $search . '%');
                    $q->orWhere('gst_number', 'like', '%' . $search . '%');
                    $q->orWhere('order_status', 'like', '%' . $search . '%');
                    $q->orWhere('pan_number', 'like', '%' . $search . '%');
                });
            }
            $total = $leads->count();
            $leads = $leads->skip($skip)->take($pageLength)->get();
            $return = [];
            foreach ($leads as $key => $lead) {

                $view_quotes = "<a href='" . route('admin_quotes_list', ['id' => $lead->id]) . "' class='btn btn-success btn-sm'>View Quotes</a>";

                $change_order_status = "<a href='javascript:void(0)' class='btn btn-secondary btn-sm changeCurrentStatus' data-qid='" . $lead->id . "'>Change Order Status</a>";

                $actions = "<a href='#' class='btn btn-primary btn-sm sendMailBtn' data-email='" . $lead->email . "' data-qid='" . $lead->id . "' title='Send Mail'><i class='fa fa-paper-plane'></i></a>";

                $actions .= "&nbsp;<a href='" . route('admin_delete_lead', ['id' => $lead->id]) . "' class='btn btn-danger mt-1 btn-sm' onclick='return confirm(\"Are you sure you want to delete this lead?\")' title='Delete Lead'><i class='fa fa-trash'></i></a>";

                $current_order_status = $lead->order_status == "pending"
                    ? "<span class='badge badge-primary'>Pending</span>"
                    : ($lead->order_status == "accept"
                        ? "<span class='badge badge-success'>Accepted</span>"
                        : "<span class='badge badge-danger'>Cancelled</span>");

                // fetch trade status
                $return[] = [
                    'id' => $key + 1,
                    'name' => $lead->name,
                    'email' => $lead->email,
                    'mobile' => $lead->mobile,
                    'quotes' => $view_quotes,
                    'gst_number' => $lead->gst_number ?? $lead->pan_number ?? '-',
                    'remarks' => $lead->remarks,
                    'order_status' => $current_order_status,
                    'change_order_status' => $change_order_status,
                    'actions' => $actions,
                ];
            }
            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $return,
            ]);
        }
        return view('leads.index');
    }

    public function quotesList($id)
    {
        try {
            $data["lead"] = Lead::find($id);
            return view('leads.view', $data);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            "qid" => "required",
        ]);
        try {
            $lead = Lead::find($request->qid);
            return response()->json(['status' => true, 'message' => "Order Successfully Fetched.", 'data' => $lead, "status_code" => 200]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => null, "status_code" => 500]);
        }
    }

    public function changeOrderStatus(Request $request)
    {
        try {
            $request->validate([
                "oid" => "required",
                "order_status" => "required|in:pending,accept,cancel",
                "cancellation_reason" => "required_if:order_status,cancel"
            ]);
            Lead::find($request->oid)->update([
                "order_status" => strtolower($request->order_status),
                "cancellation_reason" => $request->order_status == "cancel" ? $request->cancellation_reason : NULL,
            ]);

            $lead = Lead::find($request->oid);
            $setting_mail = Setting::query()->first();
            event(new OrderStatusEvent($lead, $setting_mail));

            return redirect()->back()->with("success", "Order Status successfully updated.");
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function sendMail(Request $request)
    {
        // Validate the request
        $request->validate([
            "qid" => "required",
            "recipient_email" => "required|email",
            "message" => "required",
            "attachment" => "nullable|mimes:pdf,xls,xlsx,doc,docx,jpeg,jpg,png,gif|max:5120",
        ]);

        $setting_mail = Setting::query()->first();

        if ($setting_mail) {
            // Get the validated data
            $recipientEmail = $request->input('recipient_email');
            $messageContent = $request->input('message');

            $recipient_data = Lead::find($request->qid);

            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = $file->getClientOriginalName();
                $attachmentPath = $file->storeAs('attachments', $filename, 'public');
            }

            // Send the email
            try {
                Mail::to($recipient_data->email, $recipient_data->name)->send(new SendQuoteMail($messageContent, $setting_mail, $recipient_data, $attachmentPath));

                // If an attachment was uploaded, delete it from storage
                if ($attachmentPath && Storage::disk('public')->exists($attachmentPath)) {
                    Storage::disk('public')->delete($attachmentPath);
                }

                return redirect()->back()->with('success', 'Email sent successfully!');
            } catch (\Exception $e) {
                // If something goes wrong, don't delete the file
                return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', "Please Set From Mail & From Name using setting.");
        }
    }

    public function deleteLead($id)
    {
        try {
            Lead::find($id)->delete();
            return redirect()->back()->with('success', 'Lead successfully delete!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete: ' . $e->getMessage());
        }
    }
}
