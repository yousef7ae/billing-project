<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Section;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceReport;

class ReportController extends Controller
{
    public function index1()
    {
        return view('reports.report_Invoices');
    }


    public function Search_invoices(Request $request)
    {
       
        $rdio = $request->rdio;
        
        
         // في حالة البحث بنوع الفاتورة
            
        if ($rdio == 1) {
               
               
         // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at =='' && $request->end_at =='') {

                $type = $request->type;
                //$start_at = 1;
                //$end_at = 2;    
                $invoices = Invoice::where('status',$type)->get();              
                 return view('reports.report_Invoices',compact('type','invoices'));
            }
                
                // في حالة تحديد تاريخ استحقاق
            else {
                   
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                  
                $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('status',$type)->get();
                return view('reports.report_Invoices',compact('type','start_at','end_at','invoices'));
                  
            }
        
         
                
            } 
            
        //====================================================================
            
        // في البحث برقم الفاتورة
        else {
                
            $invoices = Invoice::where('invoice_number',$request->invoice_number)->get();
            return view('reports.report_Invoices',compact('invoices'));
                
        }
        
            
             
    }

    public function export($type, $start_at , $end_at) 
    {
        return Excel::download(new InvoiceReport($type, $start_at , $end_at), 'invoices.xlsx');

    }













    ////////////////////////
    /// تقارير العملاء للاسفل /////////

 
    
    // ارجاع صفحة تقارير العملاء
    public function index2()
    {
        $sections = Section::select('*')->get();

        return view('reports.report_customer',compact('sections'));
    }

    
    // جلب تقارير العملاء (الفواتير)
    public function Search_customer(Request $request)
    {
        if($request->Section && $request->product && $request->statr_at == '' && $request->end_at == '')
        {

            $sections = Section::select('*')->get();

            $section_id = $request->Section;
            $product = $request->product;
            $invoices = Invoice::where('section_id',$section_id)->where('product',$product)->get();

            return view('reports.report_customer',compact('sections'))->withDetails($invoices);
    

        }


        else{

            $sections = Section::select('*')->get();

            $section_id = $request->Section;
            $product = $request->product;
            $start_at = $request->start_at;
            $end_at = $request->end_at;
    
            $invoices = Invoice::where('section_id',$section_id)->where('product',$product)
            ->whereBetween('due_date',[$start_at,$end_at])->get();
    
            return view('reports.report_customer',compact('sections','start_at','end_at'))->withDetails($invoices);

        }

    }







    

}
