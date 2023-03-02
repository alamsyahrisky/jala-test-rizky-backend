@extends('layouts.admin')

@section('title','Add Purchase')

@section('content')

     {{-- show error --}}
     @if ($errors->any())
        <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">
                <p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </p>
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
            <h3 class="card-title">
                Form @yield('title')
            </h3>
        </div>
        <form action="{{route('invoice.store')}}" method="POST" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Invoice Number</label>
                    <input type="text" name="code" value="{{ old('code') }}" class="form-control" placeholder="Auto Generate" readonly />
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" name="date" value="{{ old('date') }}" class="form-control" placeholder="Enter Date" />
                </div>
                <div class="form-group">
                    <label>Company</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="form-control" placeholder="Enter Date" />
                </div>
                <div class="form-group">
                    <label>Note</label>
                    <textarea name="note" id="note" class="form-control" cols="30" rows="10">{{old('note')}}</textarea>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <label for="product">Product</label>
                        <select name="product_id" id="product_id" class="form-control" onchange="changeProduct(this)">
                            <option value="">Choose Product</option>
                            @foreach ($product as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="price">Price</label>
                        <input type="number" min="0" step="1" name="price" id="price" class="form-control" placeholder="Enter price">
                    </div>
                    <div class="col-3">
                        <label for="qty">Qty</label>
                        <input type="number" min="0" step="1" name="qty" id="qty" class="form-control" placeholder="Enter qty">
                    </div>
                    <div class="col-3">
                        <a  onclick="onAddItem()" class="btn btn-success mt-8">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                        <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                    </g>
                                </svg>
                            </span>
                            Add
                        </a>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered table-checkable" id="table-invoice-detail">
                    <thead>
                        <tr>
                            <td></td>
                            <td>Product</td>
                            <td>Price</td>
                            <td>Qty</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><b>Sub Total</b></td>
                            <td>
                                <input type="text" name="price_total" id="price_total" class="form-control" readonly>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer text-right">
                <a  href="{{route('invoice.index')}}" class="btn btn-secondary">
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
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary mr-2">
                    <span class="svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="#000000" fill-rule="nonzero"/>
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                            </g>
                        </svg>
                    </span>
                    Submit
                </button>
            </div>
        </form>
        <!--end::Form-->
    </div>
@endsection

@push('new-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $('select').select2();
        $('[name=date]').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            autoclose:true,
        });

        function changeProduct(el){
            $.ajax({
                url:'../product/get_data/'+$(el).val(),
                type:'GET',
                success:function(response){
                    $('#price').val(response[0].price);
                }
            })
        }

        async function onAddItem(event){

            let dataProduct = $('#product_id').val()
            let dataQty = $('#qty').val()
            let dataPrice = $('#price').val()

            if(dataProduct === "" || dataQty == "" || dataPrice == ""){
                swal(
                    'Information',
                    'Please fill in all data',
                    'error'
                )
                event.preventDefault()
            }

            $( ".input-product" ).each(function( index ) {
                if( dataProduct === $(this).val()) {
                    swal(
                        'Information',
                        'Your product already exists',
                        'error'
                    )
                    event.preventDefault()
                }
            });
            
            let total = dataPrice * dataQty;
            $('#table-invoice-detail tbody').append(`
                <tr>
                    <td class="text-center">
                        <button type="button" onclick="deleteTemp(this)" class="btn btn-icon btn-light btn-hover-danger btn-sm" data-toggle="tooltip" title="Delete">
                            <span class="svg-icon svg-icon-md svg-icon-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                            </span>
                        </button>
                    </td>
                    <td>
                        <input type="hidden" name="detail_product_id[]" class="input-product" value="${$('#product_id').val()}">
                        ${$('#product_id').select2('data')[0].text}
                    </td>
                    <td>
                        <input type="hidden" name="detail_price[]" class="input-price" value="${dataPrice}">
                        ${dataPrice}
                    </td>
                    <td>
                        <input type="hidden" name="detail_qty[]" class="input-qty" value="${dataQty}">
                        ${dataQty}
                    </td>
                    <td>
                        <input type="hidden" name="detail_total[]" class="input-total" value="${total}">
                        ${total}
                    </td>
                </tr>
            `)
            
            await resetForm();
            await sumTotal();
        }

        function resetForm(){
            $('#product_id').val('').select2();
            $('#price').val('');
            $('#qty').val('');
        }

        function sumTotal(){
            let total = 0;
            $( ".input-total" ).each(function( index ) {
                total += parseInt($(this).val())
            });
            $('#price_total').val(total);
        }

        function deleteTemp(el){
            swal({
                title: `Confirm`,
                text: "Are you sure you want to delete this record?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(el).closest('tr').remove();
                    sumTotal();
                }
            });
        }
    </script>
@endpush