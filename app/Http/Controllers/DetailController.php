<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request,$slug){
        $product = Product::with(['category'])->where('slug',$slug)->firstOrFail();

        return view('pages.detail',[
            'item' => $product
        ]);
    }
}
