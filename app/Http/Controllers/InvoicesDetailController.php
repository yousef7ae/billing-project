<?php

namespace App\Http\Controllers;

use App\Models\Invoices_Detail;
use App\Models\Invoice;
use App\Models\Invoices_Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class InvoicesDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices_Detail  $invoices_Detail
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices_Detail $invoices_Detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices_Detail  $invoices_Detail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
       // الفاتورة بالكامل
       $invoice = Invoice::where('id',$id)->first();
      // تفاصيل الفاتورة
       $details = Invoices_Detail::where('id_Invoice',$id)->get();
      // مرفقات الفاتورة
       $attachments = Invoices_Attachment::where('invoice_id',$id)->get();

        return view('invoices.invoiceDetails',compact('invoice','details','attachments'));
    }


   //تفاصيل الفاتورة مع قراء الاشعار
    public function edit2($id)
    { 
       // الفاتورة بالكامل
       $invoice = Invoice::where('id',$id)->first();
      // تفاصيل الفاتورة
       $details = Invoices_Detail::where('id_Invoice',$id)->get();
      // مرفقات الفاتورة
       $attachments = Invoices_Attachment::where('invoice_id',$id)->get();

       $user_id = Auth::user()->id;
        
       $notification_id = DB::table('notifications')->where('data->invoice_id', $id)->where('notifiable_id',$user_id)->pluck('id');
       $notification = DB::table('notifications')->where('id',$notification_id);
       $notification->update(['read_at' => now()]);

        return view('invoices.invoiceDetails',compact('invoice','details','attachments'));
    }



    public function showArchive($id)
    {

        $invoice = Invoice::onlyTrashed()->where('id',$id)->first();

        $details = Invoices_Detail::onlyTrashed()->where('id_Invoice',$id)->get();
        // مرفقات الفاتورة
         $attachments = Invoices_Attachment::onlyTrashed()->where('invoice_id',$id)->get();
  

        return view('invoices.invoiceDetails',compact('invoice','details','attachments'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices_Detail  $invoices_Detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_Detail $invoices_Detail)
    {
        //
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices_Detail  $invoices_Detail
     * @return \Illuminate\Http\Response
     */
    //delete file
    public function destroy(Request $request)  
    {   
        
        Storage::disk('public_upload')->delete($request->invoice_number.'/'.$request->file_name);

        $id = $request->id_file;
        $file = Invoices_Attachment::findOrFail($id);
        $file->delete();
        
        
        session()->flash('delete','تم حذف الملف بنجاح');
        return back();
      
        
    }

   
   public function open_file($invoice_number,$file_name)
   {

        //$files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        //return response()->file($files);
        //$files =  Storage::get($invoice_number.'/'.$file_name);
        //$files = Storage::get('');
        // $files =  Storage::get('app/public/Attachments/'.$invoice_number.'/'.$file_name);        
        // return response()->file($files);

     return view('invoices.showImage',compact('file_name','invoice_number'));

   }


   public function download_file($invoice_number,$file_name)

   {
      return response()->download(public_path('Attachments/'.$invoice_number.'/'.$file_name));
   }
   

  
   



}
