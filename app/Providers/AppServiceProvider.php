<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('*', function ($view) 
        {
            if(Auth::user() && Auth::user()->role == 'USER'){
                $cart['total'] = Order::select('order_detail.id')->join('order_detail','order.id','=','order_detail.order_id')->where([
                    'user_id' => Auth::user()->id,
                    'status' => 'CART',
                    'order_detail.deleted_at' => null
                ])->count();
                $cart['id'] = Order::select('id')->where([
                    'user_id' => Auth::user()->id,
                    'status' => 'CART'
                ])->first();
            }else{
                $cart['id'] = null;
                $cart['total'] = 0;
            }
            $view->with('cart', $cart );    
        });  
        
        Blade::directive('rupiah', function ( $expression ) { return "Rp <?php echo number_format($expression,0,',','.'); ?>"; });
    }
}
