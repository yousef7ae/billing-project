<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('Status');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count_invoices = Invoice::count();


        $count_inv_paid = Invoice::where('value_status',1)->count();
        $rate_inv_paid = round($count_inv_paid / $count_invoices * 100 , 1);


        $count_inv_unpaid = Invoice::where('value_status',2)->count() ;
        $rate_inv_unpaid =  round($count_inv_unpaid / $count_invoices * 100 , 1 );


        $count_inv_partPaid = Invoice::where('value_status',3)->count() ;
        $rate_inv_partPaid =  round($count_inv_partPaid / $count_invoices * 100 , 1 );


        
        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['مدفوعة وغير مدفوعة', 'مدفوعة جزئيا والاجمالي'])
        ->datasets([
            [
                "label" => "النسبة المئوية",
                'backgroundColor' => ['#FF9D23', '#9016FA'],
                'data' => [$rate_inv_paid,  $rate_inv_partPaid]
            ],
            [
                "label" => "النسبة المئوية",
                'backgroundColor' => ['#E30A09', '#0AFB85'],
                'data' => [$rate_inv_unpaid, 100]
            ]
        ])
        ->options([]);





        $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['مدفوعة', 'غير مدفوعة','مدفوعة جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB','#E30A09'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB','#E30A09'],
                'data' => [ $rate_inv_paid ,  $rate_inv_unpaid, $rate_inv_partPaid]
            ]
        ])
        ->options([]);





















        return view('dashboard',compact('chartjs','chartjs2'));
    }
}
