 @extends('layouts.master')
 @section('title')
قائمة الاقسام
@stop
@section('css')

link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')


				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/قائمة الفواتير</span>
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
						
					</div>
				</div>
				<!-- breadcrumb -->
@endsection

@section('content')
				<!-- row -->
				<div class="row">

					@if ($errors->any())
                      <div class="alert alert-danger">
                         <ul>
                            @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                            @endforeach
                         </ul>
                      </div>
                    @endif

                     @if(session()->has('add'))

                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>{{ session()->get('add') }}</strong>
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                   </button>
                     </div>
                  @endif


                    @if(session()->has('edit'))

                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>{{ session()->get('edit') }}</strong>
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                   </button>
                     </div>
                  @endif

                   @if(session()->has('delete'))

                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <strong>{{ session()->get('delete') }}</strong>
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                   </button>
                     </div>
                  @endif
					 


					
					<!--/div-->

					

					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								@can('اضافة قسم')
								<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-newspaper" data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
                                @endcan
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
											  <th class="border-bottom-0">#</th>
											  <th class="border-bottom-0">اسم القسم</th>
											  <th class="border-bottom-0">الوصف</th>
										      <th class="border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
                                      <?php $id = 0; ?>
											@foreach($sections as $value)

											<?php $id++; ?> -->

											
										<tr>
											<td>{{$value->id}}</td>
											<td>{{$value->section_name}}</td>
											<td>{{$value->description}}</td>
											<td>
                                               @can('تعديل قسم')
                                               <a class="modal-effect btn btn-sm btn-info"
                                                data-effect="effect-scale"
                                                data-id="{{ $value->id }}" data-section_name="{{  $value->section_name }}"
                                                 data-description="{{ $value->description }}" data-toggle="modal" href="#exampleModal2"
                                                      title="تعديل"><i class="las la-pen"></i></a>
                                                @endcan

                                                @can('حذف قسم')
                                                 <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $value->id }}" data-section_name="{{ $value->section_name }}" data-toggle="modal"
                                                    href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
                                                @endcan
                                            </td>
												
											</tr>

											@endforeach
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->

   <!-- add section modal -->

		<div class="modal" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form  action="{{url('section/store')}}" method="POST">
							@csrf
							<div class="modal-body">

								<div class="form-group">
									<label examplInputEmail1>اسم القسم</label>
									<input autocomplete = "off" class="form-control" type="text" id = "section_name" name="section_name">
								</div>
								<div class="form-group">
									<label>ملاحظات</label>
									<textarea class="form-control" exampleFormControlTextarea1 name="description"></textarea>
								</div>
                        
                            </div>

                            <div class="modal-footer">
                            	<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                               <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
							
						</form>

					</div>
					
				</div>
			</div>
		</div>

		<!-- edit section modal -->

		<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{url('section/update')}}" method="POST" autocomplete="off">
                                            @method('patch')
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="id" id="id" value="">
                                                <label for="recipient-name" class="col-form-label">اسم القسم:</label>
                                                <input class="form-control" name="section_name" id="section_name" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">ملاحظات:</label>
                                                <textarea class="form-control" id="description" name="description"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">تاكيد</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>	
				</div>

				</div>
				<!-- row closed -->
		
	
		</div>


		   <!--delete section-->
               <div class="modal" id="modaldemo9">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                     <div class="modal-header">
                      <h6 class="modal-title">حذف القسم</h6>
                      <button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{url('section/delete')}}" method="post">
                                    @method('delete')
                                   @csrf
                                    <div class="modal-body">
                                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                        <input type="hidden" name="id" id="id" value="">
                                        <input class="form-control" name="section_name" id="section_name" type="text" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>


<script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var section_name = button.data('section_name')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var section_name = button.data('section_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #section_name').val(section_name);
        })
    </script>
@endsection