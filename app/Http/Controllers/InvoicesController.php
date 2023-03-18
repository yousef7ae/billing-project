<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoices_Detail;
use App\Models\Invoices_Attachment;
use Illuminate\Http\Request;
use App\Models\Section; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoiceAdd;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\InvoiceAdd_new;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $sections = Section::get('*');
        $invoices = Invoice::with('section')->get('*');
        return view('invoices.invoic',compact('sections','invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $sections = Section::get('*');
        return view('invoices.addInvoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        $sections = Section::get('*');

        return view('invoices.editInvoice',compact('invoice','sections'));
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
      $invoice = Invoice::where('id',$request->id)->first();
     
      $invoice->update([
        'invoice_number' => $request->invoice_number,
        'invoice_date' => $request->invoice_Date,
        'due_date' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->Section,
        'amount_collection' => $request->Amount_collection,
        'amount_commission' => $request->Amount_Commission,
        'discount' => $request->Discount,
        'value_vat' => $request->Value_VAT,
        'rate_vat' => $request->Rate_VAT,
        'total' => $request->Total,
        
    ]);

    $invoice_details = Invoices_Detail::where('id_Invoice',$request->id);
    $invoice_details->update([
        
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'Section' => $request->Section,
        'note' => $request->note,
    ]);

    $invoice_attachment = Invoices_Attachment::where('invoice_id',$request->id);


    $invoice_attachment->update([

        'invoice_number' =>$request->invoice_number,
    ]);
  



    session()->flash('update','تم تعديل الفاتورة بنجاح');
    return back();
    }
   

    /// تخززين الفاتورة
   
    public function store(Request $request) 
    {
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user'=>(Auth::user()->name)
        ]);

        $invoice_id = Invoice::latest()->first()->id;

        Invoices_Detail::create([

            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user'=>(Auth::user()->name)
        ]);

        if($request->hasFile('pic')){

            $invoice_id = Invoice::latest()->first()->id;

            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachment = new Invoices_Attachment();
            
            $attachment->file_name = $file_name;
            $attachment->invoice_number = $invoice_number;
            $attachment->invoice_id = $invoice_id;
            $attachment->Created_by = Auth::user()->name;
            $attachment->save();


            $path = $request->file('pic')->storeAs($request->invoice_number ,$file_name, 'public_upload');
            //$request->pic->move(public_path('Attachments/'.$invoice_number),$file_name);
            

        }
       
        //ارسال ايميل ..بالاضافة
        //Mail::to(Auth::user()->email)->send(new TestMail($invoice_id));

        //ارسال اشعار باضافة الفاتورة
        $users = User::where('id' , '!=' , Auth::user()->id)->get();

        Notification::send($users,new InvoiceAdd_new($invoice_id));




        session()->flash('add','تم اضافة الفاتورة بنجاح');

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
   
    public function getProduct($id)
    {

        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        
        return json_encode($products);
        
    }


    public function showStatus(Request $request , $id)
    {

        $invoice = Invoice::findOrFail($id);

        return view('invoices.statusUpdate',compact('invoice'));
    }



    public function updateStatus(Request $request ,$id)
    {
        $invoice = Invoice::findOrFail($id);
       if($request->Status ==='مدفوعة'){

        $invoice->update([

            'status' => $request->Status,
            'value_status' =>1,
            'Payment_Date' => $request->Payment_Date
        ]);

        Invoices_Detail::create([

            'id_Invoice' => $id,
            'invoice_number'=>$request->invoice_number,
            'product'=>$request->product,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => 1,
            'Payment_Date' =>$request->Payment_Date,
            'note'=> $request->note,
            'user' => (Auth::user()->name)

        ]);


    }else{

        $invoice->update([

            'status' => $request->Status,
            'value_status' =>3,
            'Payment_Date' => $request->Payment_Date
        ]);

        Invoices_Detail::create([

            'id_Invoice' => $id,
            'invoice_number'=>$request->invoice_number,
            'product'=>$request->product,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => 3,
            'Payment_Date' =>$request->Payment_Date,
            'note'=> $request->note,
            'user' => (Auth::user()->name)

        ]);

    }

        session()->flash('updated_status');

        return redirect('invoices');


    


    }


    public function destroy(Request $request)
    {   

        
        $id = $request->invoice_id;
        $invoice = Invoice::where('id',$id)->first();

        $page_num = $request->page_num;

        if($page_num == 1){

            Storage::disk('public_upload')->deleteDirectory($invoice->invoice_number);

            $invoice->forceDelete();

            session()->flash('delete_invoice');
            return back();

        }else{

            $invoice->delete();
            $details = Invoices_Detail::where('id_Invoice',$id)->get();  

           foreach($details as $detail){

             if($detail->deleted_at==null){

              $detail->deleted_at = now();;
              $detail->save();

           }
        }

          $attachments = Invoices_Attachment::where('invoice_id',$id)->get();  

           foreach($attachments as $attachment){

             if($attachment->deleted_at==null){

               $attachment->deleted_at = now();
               $attachment->save();
            }
     
        }

        session()->flash('archive_invoice');
        return back();

    }

       
       session()->flash('delete_invoice');
        return back();

   }


    public function get_paid(Request $request)
    {
        $invoices = Invoice::where('value_status', 1)->get();

        return view('invoices.paidInvoices',compact('invoices'));
    }

    public function get_partially_Paid(Request $request)
    {
        $invoices = Invoice::where('value_status', 3)->get();

        return view('invoices.partiallyPaidInvoices',compact('invoices'));
    }


    public function get_unpaid(Request $request)
    {
        $invoices = Invoice::where('value_status', 2)->get();

        return view('invoices.unpaidInvoices',compact('invoices'));
    }

    public function Print_invoice($id)
    {
         $invoice = Invoice::where('id', $id)->first();
         return view('invoices.PrintInvoice',compact('invoice'));
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');

    }

    public function markAsRead()
    {
        $notifications = auth()->user()->unreadNotifications;
        if($notifications)
        {
            $notifications->markAsRead();
            return back();

        }
    }
    
 
}















