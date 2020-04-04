<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\{product,category,attribute,values,customer,order,attr};
use Cart;
use App\Http\Requests\CheckOutRequest;
class ProductController extends Controller
{
    function ListProduct(Request $r){
        if($r->category){
            $data['products']=product::where('category_id',$r->category)->where('img','<>','no-img.jpg')->orderBy('created_at','DESC')->paginate(12);
        }
        elseif($r->start){
            $data['products']=product::whereBetween('price',[$r->start,$r->end])->where('img','<>','no-img.jpg')->orderBy('price','asc')->paginate(12);
        }
        elseif($r->value){
            $data['products']=values::find($r->value)->product()->where('img','<>','no-img.jpg')->orderBy('created_at','DESC')->paginate(12);
        }
        else{
            $data['products']=product::where('img','<>','no-img.jpg')->orderBy('created_at','DESC')->paginate(12);
        }

        $data['categories']=category::all();
        $data['attrs']=attribute::all();

        return view('frontend.product.shop',$data);
    }

    function DetailProduct($idPrd){
        $data['product']=product::find($idPrd);
        $data['products_new']=product::where('img','<>','no-img')->orderBy('created_at','desc')->take(4)->get();
        return view('frontend.product.detail',$data);
    }

    function AddCart(Request $r){
        $product=product::find($r->id_product);
        Cart::add(['id' => $product->product_code,
        'name' => $product->name,
        'price' => getprice($product,$r->attr),
        'quantity' => $r->quantity,
        'attributes' => ['img' => $product->img,'attr' => $r->attr]]);

        return redirect('product/cart');
    }

    function GetCart(){
        $data['cart']=Cart::getContent();
        $data['total']=Cart::getTotal();
        return view('frontend.product.cart',$data);
    }

    function RemoveCart($id)
    {
        Cart::remove($id);
        return redirect('product/cart');
    }

    function UpdateCart($id,$qty){
        Cart::update($id,array(
            'quantity' => array(
                'relative' => false,
                'value' => $qty
            ),
        ));
    }

    function CheckOut(){
        $data['cart']=Cart::getContent();
        $data['total']=Cart::getTotal();
        return view('frontend.checkout.checkout',$data);
    }

    function PostCheckOut(CheckOutRequest $r){
        $customer = new customer;
        $customer->full_name=$r->name;
        $customer->address=$r->address;
        $customer->email=$r->email;
        $customer->phone=$r->phone;
        $customer->total=Cart::getTotal();
        $customer->state= 0;
        $customer->save();

        foreach(Cart::getContent() as $product)
        {
            $order=new order;
            $order->name=$product->name;
            $order->price=$product->price;
            $order->quantity=$product->quantity;
            $order->img=$product->attributes->img;
            $order->customer_id=$customer->id;
            $order->save();

            foreach($product->attributes->attr as $key=>$value)
            {
                $attr=new attr;
                $attr->name=$key;
                $attr->value=$value;
                $attr->order_id=$order->id;
                $attr->save();
            }
        }
        Cart::clear();
        return redirect('product/complete/'.$customer->id);
    }

    function Complete($id_customer){
        $data['customer']=customer::find($id_customer);
        return view('frontend.product.complete',$data);
    }
}
