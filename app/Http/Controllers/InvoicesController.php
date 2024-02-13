<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\invoices;
use App\Models\sections;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInvoice;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\invoicesExport;

use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     function __construct()
{

$this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
$this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
$this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
$this->middleware('permission:تصدير EXCEL', ['only' => ['export']]);
$this->middleware('permission:طباعةالفاتورة', ['only' => ['Print_invoice']]);
$this->middleware('permission:تغير حالة الدفع', ['only' => ['Status_Update']]);

}

    public function index()
    {
        $invoices=invoices::all();
         return view('invoices.invoices',compact('invoices'));
    }


    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }


    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        //add table invoices_details
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        //add table invoice_attachments
        if ($request->hasFile('pic')) {
            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic to public ***
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        //send notification email
        //    $user = User::first();
        //    Notification::send($user, new AddInvoice($invoice_id));

        //send notification via database
        $user = Auth::user();
        $invoices = invoices::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }
    

    //show statut
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }


    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));

    }


    public function update(Request $request)
    {
        //
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }


    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();
        $id_page =$request->id_page;

        if (!$id_page==2) {

        if (!empty($Details->invoice_number)) {
            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');
        }
        else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }
     }

  
    public function Status_Update($id, Request $request)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }

    //product of section 
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    
    public function Invoice_Paid()
    {
        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoices::where('Value_Status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_Partial',compact('invoices'));
    }


    public function Print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoice',compact('invoices'));
    }
    //export invoices
    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    //read all notification (header)
    public function MarkAsRead_all (Request $request)
    {
        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
}
//search input (header)
public function searchPage(Request $request)
    {
        $search = $request->input('search');

        // Define an associative array of menu items in Arabic and their corresponding routes
        $menuItems = [
            'قائمة الفواتير' => '/invoices',
            'الفواتير المدفوعة' => '/Invoice_Paid',
            'الفواتير الغير مدفوعة' => '/Invoice_UnPaid',
            'الفواتير المدفوعة جزئيا' => '/Invoice_Partial',
            'ارشيف الفواتير' => '/Archive',
            'تقرير الفواتير' => '/invoices_report',
            'تقرير العملاء' => '/customers_report',
            'قائمة المستخدمين' => '/users',
            'صلاحيات المستخدمين' => '/roles',
            'الاقسام' => '/sections',
            'المنتجات' => '/products',
        ];

        //Check if the search term matches any menu item and redirect if found
        foreach ($menuItems as $menuItem => $route) {
            if ($search === $menuItem) {
                return redirect($route);
            }
        }

    }
}