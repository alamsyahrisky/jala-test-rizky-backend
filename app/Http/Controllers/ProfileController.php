<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profile = User::find(Auth::user()->id);
        if(Auth::user()->role == 'USER'){

            if ($request->ajax()) {
                $data = Order::join('users','users.id','=','order.user_id')->select(['order.id','number','users.name','date','status','price_total','item_total'])->where([
                    'user_id' => Auth::user()->id
                ])->where('status','<>','CART');
                return DataTables::of($data)
                        ->addColumn('action', function($row){
                            $btn = '';
                            if($row->status != 'CART'){
                                $btn .= '
                                <a title="Detail" target="_blank" href="'.route('checkout-invoice',$row->number).'" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
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
                            }
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->addIndexColumn()
                        ->make(true);
            }
            return view('pages.profile',[
                'profile' => $profile
            ]);
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
        ]);
        
        $data = $request->all();
        if($data['password'] != ''){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('profile')->with(['success' => 'Successfully updated data']);
    }
}
