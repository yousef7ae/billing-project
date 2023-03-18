<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Invoices_Detail;
use App\Models\Invoices_Attachment;

class archiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archiveInvoices',compact('invoices'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $invoice = Invoice::onlyTrashed()->where('id',$request->invoice_id)->restore();

         $details = Invoices_Detail::onlyTrashed()->where('id_Invoice',$request->invoice_id)->get();
         // مرفقات الفاتورة
         
   
         foreach($details as $detail){

             $detail->deleted_at = null;
             $detail->save();

          }

          $attachments = Invoices_Attachment::onlyTrashed()->where('invoice_id',$request->invoice_id)->get();

          foreach($attachments as $attachment){

              $attachment->deleted_at = null;
              $attachment->save();
           }

         session()->flash('restore_Invoice');
         return redirect('invoices');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = Invoice::onlyTrashed()->where('id',$request->invoice_id)->first();

        Storage::disk('public_upload')->deleteDirectory($invoice->invoice_number);

        $invoice->forceDelete();

        session()->flash('deleteFromArchive');
        return back();

        
    }
}
