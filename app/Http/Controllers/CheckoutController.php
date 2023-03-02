<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Stock;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\StockDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request,$id)
    {
        $order = Order::with('detail.product')->findOrFail($id);
        
        return view('pages.checkout',[
            'order' => $order
        ]);
    }

    public function validationStock(Request $request,$id)
    {
        $data = $request->all();
        $product = Product::find($id);
        if((int)$product->stok < (int)$data['qty']){
            $message = $product->stok.' left in stock';
            $status = "error";
        }else{
            $status = "success";
            $message = "";
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function process(Request $request,$id){
        $data = $request->all();
        
        $product = Product::findOrFail($id);
        
        $order = Order::where([
            'user_id' => Auth::user()->id,
            'status' => 'CART'
        ])->first();

        if($order){
            $order_detail = OrderDetail::where([
                'order_id' => $order->id,
                'product_id' => $product->id,
            ])->first();
            
            if($order_detail){
                $sisa = ($product->price * $order_detail['quantity']);
            }else{
                $sisa = 0;
        }

        }

        if(!$order){
            // insert order
            $order = Order::create([
                'number' => $this->generate_invoice(),
                'user_id' => Auth::user()->id,
                'date' => date('Y-m-d'),
                'status' => 'CART',
                'price_total' => $product->price * $data['quantity'],
                'item_total' => 1,
            ]);
        }else{
            
            // update order
            $order->date = date('Y-m-d');
            $order->price_total = $order->price_total - $sisa + ($product->price * $data['quantity']);
            $order->save();
        }


        if(isset($order_detail)){
            $order_detail->update([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'price' => $product->price,
                'total' => ($product->price * $data['quantity'])
            ]);
        }else{
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'price' => $product->price,
                'total' => ($product->price * $data['quantity'])
            ]);
        }

        // update total
        $get_total_item = OrderDetail::where(['order_id'=>$order->id])->count();
        $order->item_total = $get_total_item;
        $order->save();

        
        return redirect()->route('checkout',$order->id);
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

    public function remove(Request $request,$id)
    {
        $order_detail = OrderDetail::findOrFail($id);
        $order = Order::find($order_detail->order_id);
        $order->price_total = $order->price_total - $order_detail->total;
        $order->item_total = $order->item_total - 1;
        $order->save();
        $order_detail->delete();

        return redirect()->route('checkout',$order->id);
    }

    public function success(Request $request,$id)
    {
        $data = $request->all();
        $order = Order::find($id);

        $sub_total = 0;
        foreach ($data['order_id'] as $key => $value) {
            $order_detail = OrderDetail::find($value);
            $product = Product::find($order_detail->product_id);

            $price = $product->price;
            $total = $price * $data['quantity'][$key];
            $order_detail->update([
                'quantity' => $data['quantity'][$key],
                'price' => $price,
                'total' => $total
            ]);
            $sub_total += $total;

            $product->stok = $product->stok - (int) $data['quantity'][$key];
            $product->save();

            $stock = Stock::where('product_id',$product->id)->first();
            $stock->out = $stock->out + $data['quantity'][$key];
            $stock->total = $stock->total - $data['quantity'][$key];
            $stock->save();

            StockDetail::create([
                'stock_id' => $stock->id,
                'type' => 'out',
                'quantity' => $data['quantity'][$key],
                'number' => $order->number,
            ]);
        }

        $order->update([
            'date' => date('Y-m-d'),
            'status' => 'PENDING',
            'price_total' => $sub_total,
            'item_total' => count($data['order_id']),
            'note' => $data['note']
        ]);

        return view('pages.success');
    }

    public function invoice(Request $request,$code)
    {
        $invoice = Order::with('user','detail.product')->where([
            'number' => $code,
            'user_id' => Auth::user()->id
        ])->first();
        
        if($invoice){
            return view('pages.admin.order.invoice',[
                'invoice' => $invoice
            ]);
        }

        return redirect('/');
        
    }
}
