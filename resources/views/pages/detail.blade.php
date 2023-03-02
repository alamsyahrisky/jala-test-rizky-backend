@extends('layouts.app')
@section('title','Detail '.$item->name)

@push('prepend-style')
    <link rel="stylesheet" href="{{url('frontend/libraries/xzoom/src/xzoom.css')}}">
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
                              Product
                          </li>
                          <li class="breadcrumb-item active">
                            Details
                        </li>
                      </ol>
                  </nav>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12 pl-lg-0">
                  <div class="card card-detail">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="gallery">
                                @if ($item->image)
                                    <div class="xzoom-container">
                                        <img src="{{ Storage::url($item->image) }}" width="100%" alt="Gallery" class="xzoom" id="xzoom-default" xoriginal="{{ Storage::url($item->image) }}">
                                    </div>
                                @else
                                <div class="xzoom-container">
                                    <img src="{{ url('backend/dist/assets/media/error/no-image.png') }}" width="100%" alt="Gallery" class="xzoom" id="xzoom-default" xoriginal="{{ Storage::url($item->galleries->first()->image) }}">
                                </div>                      
                                @endif
                              </div>
                        </div>
                        <div class="col-lg-5">
                            <span class="text-muted">{{$item->category->name}}</span >
                            <h1><b>{{$item->name}}</b></h1>
                            <h1>@rupiah($item->price)</h1>
                            <div class="section-desc mt-5 mb-5">
                                <h2>Description</h2>
                                <p class="text-muted p-0 m-0">Condition : {{$item->condition}}</p>
                                <p class="text-muted p-0 m-0">Weight : {{$item->weight}} </p>
                                <p class="text-muted p-0 m-0">Stock : {{$item->stok}} </p>
                                <p>{!! $item->description !!}</p>
                            </div>

                            <div class="section-button join-container">
                                <form action="{{route('checkout_proses',$item->id)}}" method="post">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <input type="number" name="quantity" class="form-control mt-3 text-center" value="1" min="1" onkeyup="checkValidation()" step="1" max={{$item->stok}}>
                                            <div class="invalid-feedback" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            @auth
                                                @csrf
                                                @if (Auth::user()->role == 'USER')
                                                    @if ($item->stok > 0)
                                                        <button type="submit" class="btn btn-block btn-join-now mt-3 py-2">Add To Cart</button>
                                                    @else
                                                        <button type="submit" disabled class="disabled btn btn-block btn-join-now mt-3 py-2">Out of stock</button>
                                                    @endif
                                                @else
                                                    <button type="submit" disabled class="disabled btn btn-block btn-join-now mt-3 py-2">Only User Can Checkout</button>
                                                @endif
                                            @endauth
                                            @guest
                                                <a href="{{route('login')}}" class="btn btn-block btn-join-now mt-3 py-2">
                                                    Login or Register to Checkout
                                                </a>
                                            @endguest
                                        </div>
                                    </div>
                                </form>
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

@push('prepend-script')
<script src="{{url('frontend/libraries/xzoom/src/xzoom.js')}}"></script>
<script>
    function checkValidation(){
        let qty = $('[name=quantity]').val();
        $.ajax({
            url:"{{route('checkout_validation',$item->id)}}",
            type:'GET',
            data:{qty:qty},
            success:function(response){
                if(response.status == 'error'){
                    $('[name=quantity]').addClass('in-valid');
                    $('.invalid-feedback').show().text(response.message);
                    $('.btn-join-now').attr('disabled',true)
                }else{
                    $('[name=quantity]').removeClass('in-valid');
                    $('.invalid-feedback').hide();
                    $('.btn-join-now').attr('disabled',false)
                }
            }
        })
    }
</script>
@endpush

@push('addon-script')
<script>
    $(document).ready(function(){
        $('.xzoom, .xzoom-gallery').xzoom({
            zoomWidth:500,
            title:false,
            tint:'#333',
            Xoffset:15,
        })
    })

</script>
@endpush