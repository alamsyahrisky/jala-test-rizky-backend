@extends('layouts.admin')

@section('title','Purchase')

@push('new-style')
    <link href="{{url('backend/custom/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@section('content')

    @if ($message = Session::get('success'))
    <div class="alert alert-custom alert-light-success fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon2-quotation-mark"></i></div>
        <div class="alert-text">
            <p>{{$message}}</p>
        </div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
    @endif
    
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Data @yield('title')
            </div>
            <div class="card-toolbar">
                <a href="{{route('invoice.create')}}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>Add</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-checkable" id="table-invoice">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Invoice Number</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Item</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('new-script')
    <script src="{{url('backend/custom/jquery/jquery.min.js')}}"></script>
    <script src="{{url('backend/custom/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/custom/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('backend/custom/sweetalert/js/sweetalert.min.js')}}"></script>

    <script type="text/javascript">
        
        $(function () {
            var table = $('#table-invoice').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('invoice.index') }}",
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'  
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'number', 
                        name: 'number'
                    },
                    {
                        data: 'date', 
                        name: 'date',
                    },
                    {
                        data: 'price_total', 
                        name: 'price_total',
                        render:function(data,type){
                            return formatRupiah(data)
                        }
                    },
                    {
                        data: 'item_total', 
                        name: 'item_total',
                    },
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ],
                initComplete: function(settings, json) {
                    // $('.show_confirm').click(function(event) {
                    //     var form =  $(this).closest("form");
                    //     event.preventDefault();
                    //     swal({
                    //         title: `Confirm`,
                    //         text: "Are you sure you want to delete this record?",
                    //         icon: "warning",
                    //         buttons: true,
                    //         dangerMode: true,
                    //     })
                    //     .then((willDelete) => {
                    //         if (willDelete) {
                    //         form.submit();
                    //         }
                    //     });
                    // })
                }
            });
        });

        
    </script>
@endpush
