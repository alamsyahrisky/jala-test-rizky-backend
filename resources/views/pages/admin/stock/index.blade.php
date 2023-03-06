@extends('layouts.admin')

@section('title','Stock')

@push('new-style')
    <link href="{{url('backend/custom/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@section('content')

    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Data @yield('title')
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-checkable" id="table-stock">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Product</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Total</th>
                        <th>Last Update</th>
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

    <script type="text/javascript">

        $(function () {
            var table = $('#table-stock').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('stock.index') }}",
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'  
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'name', 
                        name: 'product.name'
                    },
                    {
                        data: 'in', 
                        name: 'in',
                    },
                    {
                        data: 'out', 
                        name: 'out',
                    },
                    {
                        data: 'total', 
                        name: 'total',
                    },
                    {
                        data: 'updated_at', 
                        name: 'updated_at',
                    },
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ],
                initComplete: function(settings, json) {
                }
            });
        });

        
    </script>
@endpush
