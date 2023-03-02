<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $income = Order::where('status', 'SUCCESS')->sum('price_total');
        $customer = User::where('role','USER')->count();
        $success_order = Order::where('status','SUCCESS')->count();
        $pending_order = Order::where('status','PENDING')->count();
        $recent_order = Order::with('user')->orderBy('date','DESC')->limit(5)->get();

        return view('pages.admin.dashboard',[
            'income' => $income,
            'customer' => $customer,
            'success_order' => $success_order,
            'pending_order' => $pending_order,
            'recent_order' => $recent_order,
        ]);
    }

    public function getCategory()
    {
        $category = Category::select('name as category','id')->get();
        return response()->json($category);
    }

    public function getOrder()
    {
        $order = Order::select(
            "date" ,
            DB::raw("(count(*)) as value"))
            ->groupBy('date')
            ->get();

        return response()->json($order);
    }
}
