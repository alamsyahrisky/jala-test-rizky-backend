@extends('layouts.app')

@section('title','Home')

@section('content')
    <!-- Header -->
    <header class="text-center">
    </header>

    <!-- Main -->
    <main>
        <!-- Statistic -->
        <div class="container">
            <div class="section-start row justify-content-center">
                <div class="col-7 start-detail">
                        <form action="{{ route('home') }}" method="GET" autocomplete="off">
                            <input class="form-control form-control-lg" type="text" name="s" placeholder="Search Product" value="{{Request::input('s')}}">
                        </form>
                    </div>
            </div>
        </div>
        <!-- Popular -->
        <section class="section-popular" id="popular">
            <div class="container">
                <div class="row">
                    <div class="col text-center section-popular-heading">
                        <h2>Featured Product</h2>
                        <p>
                            Our products provide comfort for you
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-popular-content" id="product">
            <div class="container">
                <div class="section-popular-travel row justify-content-center">
                    @forelse ($product as $p)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a href="{{route('detail',$p->slug)}}" style="text-decoration:none;">
                                <div class="card">
                                    <img class="card-img-top" src="{{ ($p->image != null ? Storage::url($p->image) : url('backend/dist/assets/media/error/no-image.png'))}}" alt="Card image cap">
                                    <div class="card-body">
                                    <span class="text-muted">{{$p->category->name}}</span>
                                    <h5 class="card-title">{{$p->name}}</h5>
                                    <h5 class="card-text font-weight-bold"><td>@rupiah($p->price)</td></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <h2>Product Is Empty</h2>
                        </div>                        
                    @endforelse
                    <div class="row text-center" style="margin-top:100px">
                        {{ $product->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection