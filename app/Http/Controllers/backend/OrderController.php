<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\customer;

class OrderController extends Controller
{
    function ListOrder(){
        $data['customers']=customer::where('state',0)->orderBy('created_at','DESC')->get();
        return view('backend/order/order',$data);
    }

    function DetailOrder($customer_id){
        $data['customer']=customer::find($customer_id);
        return view('backend/order/detailorder',$data);
    }

    function Processed(){
        $data['customers']=customer::where('state',1)->orderBy('updated_at','DESC')->get();
        return view('backend/order/orderprocessed',$data);
    }

    function ActivelOrder($customer_id){
        $customer=customer::find($customer_id);
        $customer->state=1;
        $customer->save();
        return redirect('admin/order')->with('thongbao','Đơn hàng đã được xử lý!');
    }
}
