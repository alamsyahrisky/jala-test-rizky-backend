<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\StockDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::join('users','users.id','=','order.user_id')->select(['order.id','number','users.name','date','status','price_total','item_total']);
            return DataTables::of($data)
                    ->addColumn('action', function($row){
                        $btn = '
                        <a title="Detail" href="'.route('order.show',$row->id).'" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
                            <span class="svg-icon svg-icon-md svg-icon-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                        </a>
                        ';
                        if($row->status != 'CART'){
                            $btn .= '
                            <a title="Update Status" href="javascript:;" data-id="'.$row->id.'" data-status="'.$row->status.'" data-toggle="modal" data-target="#modal-status" class="btn btn-icon btn-light btn-hover-primary btn-sm btn_update_status">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                            ';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('pages.admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('role','USER')->get();
        $product = Product::where('stok','>',0)->get();
        
        return view('pages.admin.order.create',[
            'user' => $user,
            'product' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'user_id' => 'required',
            'status' => 'required',
            'detail_product_id' => 'required|array',
        ]);

        $data = $request->all();
        $data['number'] = $this->generate_invoice();
        $data['date'] = date('Y-m-d',strtotime($data['date']));
        $data['item_total'] = count($data['detail_product_id']);
        $order = Order::create($data);

        foreach ($data['detail_product_id'] as $key => $value) {
            $detail['order_id'] = $order->id;
            $detail['product_id'] = $value;
            $detail['quantity'] = $data['detail_qty'][$key];
            $detail['price'] = $data['detail_price'][$key];
            $detail['total'] = $data['detail_total'][$key];

            OrderDetail::create($detail);
            
            $product = Product::find($value);
            $product->stok = $product->stok - (int) $data['detail_qty'][$key];
            $product->save();

            $stock = Stock::where('product_id',$value)->first();
            $stock->out = $stock->out + $data['detail_qty'][$key];
            $stock->total = $stock->total - $data['detail_qty'][$key];
            $stock->save();

            StockDetail::create([
                'stock_id' => $stock->id,
                'type' => 'out',
                'quantity' => $data['detail_qty'][$key],
                'number' => $order->number,
            ]);
        }


        return redirect()->route('order.index')->with(['success' => 'Successfully saved data']);
    }

    public function generate_invoice()
    {
        $date = date('dmY');
        $current_prefix = 'SO-'.$date.'-';
        $invoice =  Order::latest('created_at')->first();
        if($invoice){
            $invoice_digit = explode('-',$invoice['number']);
            $invoice_number = (int) $invoice_digit[2] + 1;
        }else{
            $invoice_number = 1;
        }
        $number = $current_prefix . str_pad(
            $invoice_number,
            3, 
            '0',
            STR_PAD_LEFT
        );

        return $number;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Order::with('user','detail.product')->find($id);
        return view('pages.admin.order.show',[
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Order $order)
    {
        $data = $request->all();
        $order->update($data);
        return redirect()->route('order.index')->with(['success' => 'Successfully updated data']);
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
