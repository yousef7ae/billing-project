<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::select('invoice_number','invoice_date','due_date','product','amount_collection','amount_commission','discount','value_vat','rate_vat','total','status','user','Payment_Date')->get();
    }
}
