@extends('layouts.admin')

@section('title','Detail Purchase')

@section('content')

    <div class="card card-custom overflow-hidden">
        <div class="card-body p-0">
            <!-- begin: Invoice-->
            <!-- begin: Invoice header-->
            <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                        <h1 class="display-4 font-weight-boldest mb-10">
                            INVOICE<br>
                            PURCHASE ORDER
                        </h1>
                        <div class="d-flex flex-column align-items-md-end px-0">
                            <!--begin::Logo-->
                            <a href="#" class="mb-5">
                                <img src="{{url('backend/dist/assets/media/logos/jala.png')}}" style="max-width: 150px" alt="" />
                            </a>
                            <!--end::Logo-->
                            <span class="d-flex flex-column align-items-md-end opacity-70">
                                <span>Jl. Babarsari No.2, Janti, Caturtunggal,</span>
                                <span>Daerah Istimewa Yogyakarta 55281</span>
                            </span>
                        </div>
                    </div>
                    <div class="border-bottom w-100"></div>
                    <div class="d-flex justify-content-between pt-6">
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Date</span>
                            <span class="opacity-70">{{$invoice->date}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">INVOICE NO.</span>
                            <span class="opacity-70">{{$invoice->number}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">COMPANY</span>
                            <span class="opacity-70">{{$invoice->company}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->
            <!-- begin: Invoice body-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">Product</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Price</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                    <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->detail as $item)
                                    <tr class="font-weight-boldest">
                                        <td class="pl-0 pt-7">{{$item->product->name}}</td>
                                        <td class="text-right pt-7">@rupiah($item->price)</td>
                                        <td class="text-right pt-7">{{$item->quantity}}</td>
                                        <td class="text-danger pr-0 pt-7 text-right">@rupiah($item->total)</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end: Invoice body-->
            <!-- begin: Invoice footer-->
            <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-muted text-uppercase" colspan="3">NOTE</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">TOTAL AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="font-weight-bolder">
                                    <td colspan="3">{{$invoice->note}}</td>
                                    <td class="text-right text-danger font-size-h3 font-weight-boldest">@rupiah($invoice->price_total)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end: Invoice footer-->
            <!-- begin: Invoice action-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
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
                            Back
                        </a>
                    </div>
                </div>
            </div>
            <!-- end: Invoice action-->
            <!-- end: Invoice-->
        </div>
    </div>
@endsection