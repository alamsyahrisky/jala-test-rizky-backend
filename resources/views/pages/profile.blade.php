@extends('layouts.app')

@section('title','Profile')

@push('addon-style')
    <link href="{{url('backend/custom/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush


@section('content')
<main>
    <section class="section-detail-header">
    </section>
    <section class="section-detail-content">
      <div class="container">
          <div class="row">
              <div class="col">
                  <nav>
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            Jala
                        </li>
                        <li class="breadcrumb-item active">
                            Profile
                        </li>
                      </ol>
                  </nav>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12 pl-lg-0">
                <div class="card mb-3" style="max-width: 450px; margin-top:60px">
                    <div class="row g-0">
                      <div class="col-4">
                        <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}" class="img-fluid rounded-start w-100 h-100" alt="Profile">
                      </div>
                      <div class="col-8">
                        <div class="card-body">
                          <h5 class="card-title">{{Auth::user()->name}}</h5>
                          <p class="card-text"><small class="text-muted">{{Auth::user()->email}}</small></p>
                          <form class="form-inline" action="{{url('logout')}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-login">Logout</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                        <strong>Success</strong> {{$message}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                            <strong>Error</strong> 
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                  <nav class="mt-5">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Profile</button>
                      <button class="nav-link" onclick="dataOrder()" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">History</button>
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="container">
                            <div class="card mt-5 mx-lg-5">
                                <div class="card-header">
                                    Edit Profile
                                </div>
                                <form action="{{route('update-profile',$profile->id)}}" method="POST" autocomplete="off">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="mx-lg-5">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" value="{{$profile->name}}">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{$profile->email}}">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="number" class="form-control" name="phone" value="{{$profile->phone}}">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control" name="address" value="{{$profile->address}}">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password">
                                                <div class="form-text">Please fill in the password if you want to change it</div>
                                            </div>
                                            <hr>
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-login">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="container">
                            <div class="card mt-5 mx-lg-5">
                                <div class="card-header">
                                    History Purchase
                                </div>
                                <div class="card-body">
                                    <div class="mx-lg-5">
                                        <table class="table table-striped table-hover" id="table-order">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Number</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div> 
              </div>
          </div>
      </div>
    </section>
</main>
@endsection

@push('addon-script')
    <script src="{{url('backend/custom/jquery/jquery.min.js')}}"></script>
    <script src="{{url('backend/custom/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/custom/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('backend/custom/sweetalert/js/sweetalert.min.js')}}"></script>

    <script type="text/javascript">

        function dataOrder(){
            $('#table-order').dataTable().fnClearTable();
            $('#table-order').dataTable().fnDestroy();

            var table = $('#table-order').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('profile') }}",
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
                            return `<span class="badge bg-${status}">${data}</span>`
                        }
                    },
                    {
                        data: 'price_total', 
                        name: 'price_total',
                        render:function(data,type){
                            return formatRupiah(data)
                        }
                    },
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ],
                initComplete: function(settings, json) {
                }
            });
        }

        
    </script>
@endpush