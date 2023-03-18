@extends('layouts.master')
@section('css')
<style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Invoice</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">Invoice</h1>
										<div class="billed-from">
											<h6>{{Auth::user()->name}}</h6>
											<p>201 Something St., Something Town, YT 242, Country 6546<br>
											Tel No: 324 445-4544<br>
											Email: youremail@companyname.com</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Billed To</label>
											<div class="billed-to">
												<h6>{{Auth::user()->email}}</h6>
												<p>4033 Patterson Road, Staten Island, NY 10301<br>
												Tel No: 324 445-4544<br>
												Email: youremail@companyname.com</p>
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-1000">معلومات الفاتورة</label>
											<p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{$invoice->invoice_number}}</span></p>
											<p class="invoice-info-row"><span> تاريخ الاصدار</span> <span>{{$invoice->invoice_date}}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاستحقاق </span> <span>{{$invoice->due_date}}</span></p>
											<p class="invoice-info-row"><span>القسم</span> <span>{{$invoice->section->section_name}}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													
													<th class="wd-25p tx-center">المنتج</th>
													<th class="wd-25p tx-center">مبلغ التحصيل</th>
													<th class="wd-25p tx-right"> مبلغ العمولة</th>
													<th class="wd-25p tx-right">الاجمالي</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													
													<td class="tx-14 tx-center">{{$invoice->product}}</td>
													<td class="tx-center">{{number_format($invoice->amount_collection)}}</td>
													<td class="tx-right">{{number_format($invoice->amount_commission)}}</td>
                                                    @php

                                                   $total =  $invoice->amount_collection + $invoice->amount_commission

                                                    @endphp
													<td class="tx-right">{{number_format($total)}}</td>
												</tr>
												
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															
															<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
														</div><!-- invoice-notes -->
													</td>
													<td class="tx-right">الاجمالي</td>
													<td class="tx-right" colspan="2">{{number_format($total)}}</td>
												</tr>
												<tr>
													<td class="tx-right">نسبة الضريبة</td>
													<td class="tx-right" colspan="2">{{$invoice->rate_vat}}</td>
												</tr>
												<tr>
													<td class="tx-right">الخصم</td>
													<td class="tx-right" colspan="2">{{$invoice->discount}}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل اضريبة</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">{{number_format($invoice->total)}}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									
                                    <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printInv()"> <i
                                class="mdi mdi-printer ml-1"></i>طباعة</button>
								
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>


   <script type = "text/javascript">

    function printInv(){

        var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
    }



   </script>
@endsection