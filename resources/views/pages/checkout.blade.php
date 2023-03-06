@extends('layouts.checkout')

@section('title','Checkout')

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
                              Product
                          </li>
                          <li class="breadcrumb-item active">
                            Checkout
                        </li>
                      </ol>
                  </nav>
              </div>
          </div>
          <form action="{{route('checkout-success',$order->id)}}" method="POST" autocomplete="off">
            @csrf
            <div class="row">
              <div class="col-lg-8 pl-lg-0">
                  <div class="card card-detail">
                        @if ($errors->any())
                            <div class="aler alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <label>{{$error}}</label>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                      <h1>Purchased items</h1>
                      <div class="attend">
                          <table class="table table-responsive-sm">
                              <thead>
                                  <tr>
                                      <th>Product</th>
                                      <th>Price</th>
                                      <th>Quantity</th>
                                      <th>Total</th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @forelse ($order->detail as $detail)
                                    <tr>
                                        <td class="align-middle">
                                            <input type="hidden" name="order_id[]" value="{{$detail->id}}">
                                            <input type="hidden" name="product_id[]" value="{{$detail->product_id}}">
                                            <img src="{{Storage::url($detail->product->image)}}" height="60" class="rounded">
                                            <span class="px-2">{{$detail->product->name}}</span>
                                        </td>
                                        <td class="align-middle">
                                            @rupiah($detail->price)
                                            <input type="hidden" name="price[]" class="input-price" value="{{$detail->price}}">
                                        </td>
                                        <td class="align-middle">
                                            <input type="number" required data-id="{{$detail->product->id}}" class="form-control input-qty text-center w-50 m-auto" min="1" step="1" name="quantity[]" value="{{$detail->quantity}}">
                                            <div class="invalid-feedback" style="display: none;">
                                            </div>
                                        </td>
                                        <td class="align-middle text-total">
                                            @rupiah($detail->total)
                                        </td>
                                        <td class="align-middle">
                                            <input type="hidden" name="total[]" class="input-total" value="{{$detail->total}}">
                                            <a href="{{route('checkout-remove',$detail->id)}}">
                                                <img src="{{url('frontend/images/ic_remove.png')}}" alt="">
                                            </a>
                                        </td>
                                    </tr>
                                  @empty
                                      <tr>
                                        <td colspan="5" class="text-center">
                                            <h3>
                                                Cart is empty, please add items to cart
                                                <a href="{{route('home')}}#product" class="btn btn-add-now">Shop Now</a>
                                            </h3>
                                        </td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                      <div class="member mt-3">
                          <h3>Note</h3>
                          <div class="row">
                            <div class="col">
                                <textarea name="note" id="note" cols="10" rows="5" class="form-control mb-2 mr-sm-2"></textarea>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="card card-detail card-right">
                      <h2>Checkout Information</h2>
                      <table class="trip-information">
                          <tr>
                              <th width="50%">
                                Name
                              </th>
                              <th width="50%" class="text-end">
                                {{$order->user->name}}
                              </th>
                          </tr>
                          <tr>
                              <th width="50%">
                                  Phone
                              </th>
                              <th width="50%" class="text-end">
                                {{$order->user->phone}}
                              </th>
                          </tr>
                          <tr>
                              <th width="50%">
                                  Address
                              </th>
                              <th width="50%" class="text-end">
                                  {{$order->user->address}}
                              </th>
                          </tr>
                          <tr>
                              <th width="50%">
                                  Total Item
                              </th>
                              <th width="50%" class="text-end">
                                  {{$order->item_total}}
                              </th>
                          </tr>
                          <tr>
                              <th width="50%">
                                  Sub Total
                              </th>
                              <th width="50%" class="text-end text-total">
                                  <span class="text-blue" id="sub-total">@rupiah($order->price_total)</span>
                              </th>
                          </tr>
                      </table>
                      <hr>
                      <h2>Payment Instructions</h2>
                      <p class="payment-instruction"> 
                        Please pay via GO-PAY and confirm to admin
                      </p>
                      <img src="{{url('frontend/images/gopay.png')}}" alt="" class="w-50">
                  </div>
                  <div class="join-container">
                        <button type="submit" class="btn btn-block btn-join-now mt-3 py-2">
                            Checkout
                        </button>
                  </div>
                  <div class="text-center mt-3">
                      <a href="{{route('home')}}#product" class="text-muted">Continue Shoping</a>
                  </div>
              </div>
            </div>
          </form>
      </div>
    </section>
</main>

@endsection

@push('addon-script')
<script>
    $(".input-qty").on('change', function(e) {
        let id = $(this).data('id')
        let qty = $(this).val();
        let element = $(this);
        $.ajax({
            url:'../checkout/validation/'+id,
            type:'GET',
            data:{qty:qty},
            success:function(response){
                if(response.status == 'error'){
                    $(element).next().show().text(response.message);
                    $('.btn-join-now').addClass('disabled')
                }else{
                    $(element).next().hide();
                    $('.btn-join-now').removeClass('disabled')
                }
            }
        })
        updateTotal(element)
        e.preventDefault();
    });

    function updateTotal(el){
        let qty = $(el).val();
        let price = $(el).closest('tr').find('.input-price').val();
        let total = parseInt(qty)  * parseInt(price);
        $(el).closest('tr').find('.text-total').text(formatRupiah(total))
        $(el).closest('tr').find('.input-total').val(total)

        sumTotal();
    }

    function sumTotal(){
        let total = 0;
        $( ".input-total" ).each(function( index ) {
            total += parseInt($(this).val())
        });
        $('#sub-total').text(formatRupiah(total));
    }
</script>
@endpush
