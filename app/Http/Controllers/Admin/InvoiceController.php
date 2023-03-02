<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockDetail;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::select(['id','number','date','price_total','item_total']);
            return DataTables::of($data)
                    ->addColumn('action', function($row){
                        $btn = '
                        <a title="Detail" href="'.route('invoice.show',$row->id).'" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
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
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('pages.admin.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('pages.admin.invoice.create',[
            'product' => $products
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
            'detail_product_id' => 'required|array',
        ]);

        $data = $request->all();
        $data['number'] = $this->generate_invoice();
        $data['date'] = date('Y-m-d',strtotime($data['date']));
        $data['item_total'] = count($data['detail_product_id']);
        $invoice = Invoice::create($data);

        foreach ($data['detail_product_id'] as $key => $value) {
            $detail['invoice_id'] = $invoice->id;
            $detail['product_id'] = $value;
            $detail['quantity'] = $data['detail_qty'][$key];
            $detail['price'] = $data['detail_price'][$key];
            $detail['total'] = $data['detail_total'][$key];

            InvoiceDetail::create($detail);
            
            $product = Product::find($value);
            $product->stok = $product->stok + (int) $data['detail_qty'][$key];
            $product->save();

            $stock = Stock::where('product_id',$value)->first();
            if(!$stock){
                $stock = Stock::create([
                    'product_id' => $value,
                    'in' => $data['detail_qty'][$key],
                    'out' => 0,
                    'total' => $data['detail_qty'][$key],
                ]);
            }else{
                $stock->in = $stock->in + $data['detail_qty'][$key];
                $stock->total = $stock->total + $data['detail_qty'][$key];
                $stock->save();
            }

            StockDetail::create([
                'stock_id' => $stock->id,
                'type' => 'in',
                'quantity' => $data['detail_qty'][$key],
                'number' => $invoice->number,
            ]);
        }


        return redirect()->route('invoice.index')->with(['success' => 'Successfully saved data']);
    }

    public function generate_invoice()
    {
        $date = date('dmY');
        $current_prefix = 'PO-'.$date.'-';
        $invoice =  Invoice::latest('created_at')->first();
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
        $invoice = Invoice::with('detail.product')->find($id);
        return view('pages.admin.invoice.show',[
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
    public function update(Request $request, $id)
    {
        //
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
