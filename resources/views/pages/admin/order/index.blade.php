@extends('layouts.admin')

@section('title','Order')

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
                <a href="{{route('order.create')}}" class="btn btn-primary font-weight-bolder">
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
            <table class="table table-bordered table-checkable" id="table-order">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Number</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Status</th>
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

    <div class="modal fade" id="modal-status" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form action="#" method="POST" autocomplete="off" id="form-status">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Choose Status</option>
                                <option value="PENDING">PENDING</option>
                                <option value="SUCCESS">SUCCESS</option>
                                <option value="CANCEL">CANCEL</option>
                                <option value="PROCESS">PROCESS</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                            <rect x="0" y="7" width="16" height="2" rx="1"/>
                                            <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="#000000" fill-rule="nonzero"/>
                                        <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                                    </g>
                                </svg>
                            </span>
                            Update
                        </button>
                    </div>
                </form>
            </div>
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
            var table = $('#table-order').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('order.index') }}",
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
                        data: 'name', 
                        name: 'users.name'
                    },
                    {
                        data: 'date', 
                        name: 'date',
                    },
                    {
                        data: 'status', 
                        name: 'status',
                        render:function(data,type){
                            switch (data) {
                                case "CART":
                                    status = 'warning';
                                    break;
                                case "PENDING":
                                    status = 'info';
                                    break;
                                case "SUCCESS":
                                    status = 'success';
                                    break;
                                case "CANCEL":
                                    status = 'danger';
                                    break;
                                case "PROCESS":
                                    status = 'primary';
                                    break;  
                                default:
                                    status = 'secondary';
                                    break;
                            }
                            return `<span class="label label-lg label-light-${status} label-inline">${data}</span>`
                        }
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
                    $('.btn_update_status').click(function(event) {
                        let id = $(this).data('id');
                        let status = $(this).data('status');

                        $('#status').val(status)

                        $('#form-status').attr('action','{{url("admin/order")}}'+'/'+id);
                        
                    })
                }
            });

            table.on( 'draw', function () {
                $('.btn_update_status').click(function(event) {
                    let id = $(this).data('id');
                    let status = $(this).data('status');
        
                    $('#status').val(status)
        
                    $('#form-status').attr('action','{{url("admin/order")}}'+'/'+id);
                    
                })
            });
        });


        
    </script>
@endpush
