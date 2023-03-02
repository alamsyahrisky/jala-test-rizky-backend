@extends('layouts.admin')

@section('title','Stock '.$item->product->name)

@push('new-style')
    <link href="{{url('backend/custom/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@section('content')

    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Stock {{$item->product->name}}
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-checkable" id="table-stock">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Number</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            <a  href="{{route('stock.index')}}" class="btn btn-secondary">
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
                Back
            </a>
        </div>
    </div>
@endsection

@push('new-script')
    <script src="{{url('backend/custom/jquery/jquery.min.js')}}"></script>
    <script src="{{url('backend/custom/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/custom/datatable/js/dataTables.bootstrap4.min.js')}}"></script>

    <script type="text/javascript">

        $(function () {
            var table = $('#table-stock').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('stock.show',$item->id) }}",
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'  
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'type', 
                        name: 'type',
                        render:function(data,type){
                            return `<span class="label label-lg label-light-${data == 'in' ? 'success' : 'danger'} label-inline">${data}</span>`
                        }
                    },
                    {
                        data: 'quantity', 
                        name: 'quantity',
                    },
                    {
                        data: 'number', 
                        name: 'number',
                    },
                    {
                        data: 'created_at', 
                        name: 'created_at',
                    },
                ],
                initComplete: function(settings, json) {
                }
            });
        });

        
    </script>
@endpush