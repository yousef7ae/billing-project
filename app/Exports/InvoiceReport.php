<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoiceReport implements FromCollection
{
   public $type;
   public $start_at;
   public $end_at;



    function __construct($type, $start_at , $end_at )
    {
        $this->type = $type;
        $this->start_at = $start_at;
        $this->end_at = $end_at;
      

    }

    public function collection()
    {
        if(isset($type) && $this->start_at ==1 && $this->end_at == 2){
        return Invoice::where('status',$this->type)->select('invoice_number','invoice_date','due_date','product','amount_collection','amount_commission','discount','value_vat','rate_vat','total','status','user','Payment_Date')->get();
        }

        else{
            return Invoice::where('status',$this->type)->whereBetween('invoice_date',[$this->start_at,$this->end_at])->select('invoice_number','invoice_date','due_date','product','amount_collection','amount_commission','discount','value_vat','rate_vat','total','status','user','Payment_Date')->get();
        }
        
    }
}
