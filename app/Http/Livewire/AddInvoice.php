<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddInvoice extends Component
{
    
    public function render()
    {
        return view('livewire.add-invoice');
    }

    public add()
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
    }
}
