<?php

namespace App\Http\Controllers;

use App\Models\Invoices_Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentController extends Controller
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
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',
    
            ],
             [
                'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]
        );

        $image = $request->file('file_name');
        $imageName = $image->getClientOriginalName();

        $attachment = new Invoices_Attachment();
        $attachment->file_name = $imageName;
        $attachment->invoice_id = $request->invoice_id;
        $attachment->invoice_number = $request->invoice_number;
        $attachment->Created_by = Auth::user()->name;
        $attachment->save();

        $file_name = $request->file_name->getClientOriginalName();

        $request->file('file_name')->storeAs($request->invoice_number ,$imageName, 'public_upload');
        session()->flash('add','تم اضافة المرفق بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices_Attachment  $invoices_Attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices_Attachment $invoices_Attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices_Attachment  $invoices_Attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_Attachment $invoices_Attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices_Attachment  $invoices_Attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_Attachment $invoices_Attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices_Attachment  $invoices_Attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Invoices_Attachment $invoices_Attachment)
    {
        
    }

   
}
