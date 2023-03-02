@extends('layouts.admin')

@section('title','Edit Product')

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
        <form action="{{route('product.update',$item->id)}}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') ?? $item->sku }}" class="form-control" placeholder="Auto Generate" readonly />
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') ?? $item->name }}" class="form-control" placeholder="Enter name" />
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Enter description">{{ old('description') ?? $item->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" min="0" step="1" name="price" value="{{ old('price') ?? $item->price }}" class="form-control" placeholder="Enter price" />
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" />
                    <span>Please fill in if you want to update the image</span>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($category as $item_category)
                        <option {{ $item->category_id == $item_category->id ? 'selected' : '' }} value="{{$item_category->id}}">{{$item_category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label> </label>
                    <select name="condition" class="form-control">
                        <option value="">Select Condition</option>
                        <option {{ $item->condition == 'Baru' ? 'selected' : '' }} value="Baru">Baru</option>
                        <option {{ $item->condition == 'Bekas' ? 'selected' : '' }} value="Bekas">Bekas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Weight</label>
                    <input type="number" min="0" name="weight" value="{{ old('weight') ?? $item->weight }}" class="form-control" placeholder="Enter weight" />
                </div>
            </div>
            <div class="card-footer text-right">
                <a  href="{{route('product.index')}}" class="btn btn-secondary">
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