<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{AddProductRequest,EditProductRequest,AddAttrRequest,AddValueRequest,EditAttrRequest,EditValueRequest};
use App\models\product;
use App\models\attribute;
use App\models\values;
use App\models\category;
use App\models\variant;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    function ListProduct(){
        $data['products']=product::paginate(3);
        return view('backend/product/listproduct',$data);
    }

    function AddProduct(){
        $data['category']=category::all();
        $data['attrs']=attribute::all();
        return view('backend/product/addproduct',$data);
    }

    function PostAddProduct(AddProductRequest $r){
        $product =new product;
        $product->product_code=$r->product_code;
        $product->name=$r->product_name;
        $product->price=$r->product_price;
        $product->featured=$r->feature;
        $product->state=$r->product_state;
        $product->info=$r->info;
        $product->describe=$r->description;
        if($r->hasFile('product_img')){
            $file=$r->product_img;
            $filename=Str::random(9).'.'.$file->getClientOriginalExtension();
            $file->move('backend/img', $filename);
            $product->img=$filename;
        }else{
            $product->img='no-img.jpg';
        }

        $product->category_id=$r->category;
        $product->save();

        // add values

        $mang = array();
        foreach($r->attr as $value){
            foreach($value  as $row){
                $mang[]=$row;
            }
        }
        $product->values()->attach($mang);

        // add variant

        $variant=get_combinations($r->attr);
        foreach($variant as $var){
            $vari = new variant;
            $vari->product_id=$product->id;
            $vari->save();
            $vari->values()->attach($var);
        }
        return redirect('admin/product/add-variant/'.$product->id);
    }

    function EditProduct($idPrd){
        $data['product']=product::find($idPrd);
        $data['category']=category::all();
        $data['attrs']=attribute::all();
        return view('backend/product/editproduct',$data);
    }

    function PostEditProduct(EditProductRequest $r,$idPrd){
        $product=product::find($idPrd);
        $product->product_code=$r->product_code;
        $product->name=$r->product_name;
        $product->price=$r->product_price;
        $product->featured=$r->feature;
        $product->state=$r->product_state;
        $product->info=$r->info;
        $product->describe=$r->description;
        if($r->hasFile('product_img')){
            if($product->img!='no-img.jpg'){
                unlink('backend/img/'.$product->img);
            }
            $file=$r->product_img;
            $filename=Str::random(9).'.'.$file->getClientOriginalExtension();
            $file->move('backend/img', $filename);
            $product->img=$filename;
        }

        $product->category_id=$r->category;
        $product->save();

        // add values
        $mang = array();
        foreach($r->attr as $value){
            foreach($value  as $row){
                $mang[]=$row;
            }
        }
        $product->values()->sync($mang);

        // add ariant
        $variant=get_combinations($r->attr);
        foreach($variant as $var){
            if(check_variant($product,$var))
            {
                $vari = new variant;
                $vari->product_id=$product->id;
                $vari->save();
                $vari->values()->attach($var);
            }

        }

        return redirect()->back()->with('thongbao','Đã sửa thành công sản phẩm!');
    }

    function DelProduct($idPrd){
        product::destroy($idPrd);
        return redirect()->back()->with('thongbao','Đã xóa thành công sản phẩm');
    }

    function DetailAttr(){
        $data['attrs']=attribute::all();
        return view('backend/attr/attr',$data);
    }

    function AddAttr(AddAttrRequest $r){
        $attr = new attribute;
        $attr->name=$r->attr_name;
        $attr->save();
        return redirect()->back()->with('thongbao','Đã thêm thành công thuộc tính: '.$r->attr_name);
     }

    function EditAttr($idAttr){
        $data['attr']=attribute::find($idAttr);
        return view('backend/attr/editattr',$data);
    }

    function PostEditAttr(EditAttrRequest $r,$idAttr){
        $attr = attribute::find($idAttr);
        $attr->name=$r->attr_name;
        $attr->save();
        return redirect('/admin/product/detail-attr')->with('thongbao','Đã sửa thành công thuộc tính thành :'.$r->attr_name);
    }

    function DelAttr($idAttr){
        attribute::destroy($idAttr);
        return redirect('/admin/product/detail-attr')->with('thongbao','Đã xóa thành công thuộc tính!');
    }

    function AddValue(AddValueRequest $r){
        $value = new values;
        $value->value=$r->value_name;
        $value->attr_id=$r->attr_id;
        $value->save();
        return redirect()->back()->with('thongbao','Đã thêm thành công giá trị: '.$r->value_name.' của thuộc tính '.$value->attribute->name);
    }

    function EditValue($idValue){
        $data['value']=values::find($idValue);
        return view('backend/attr/editvalue',$data);
    }

    function PostEditValue(EditValueRequest $r,$idValue){
        $value = values::find($idValue);
        $value->value=$r->value_name;
        $value->save();
        return redirect('/admin/product/detail-attr')->with('thongbao','Đã sửa thành công giá trị thành: '.$r->value_name);
    }

    function DelValue($idValue){
        values::destroy($idValue);
        return redirect()->back()->with('thongbao','Đã xóa thành công giá trị!');
    }

    function AddVariant($idPrd){
        $data['product']=product::find($idPrd);
        return view('backend/variant/addvariant',$data);
    }

    function PostAddVariant($idPrd, Request $r){
        $product=product::find($idPrd);
        foreach($r->variant as $key=>$value)
        {
            $vari=variant::find($key);
            $vari->price=$value;
            $vari->save();
        }
        return redirect('/admin/product')->with('thongbao','Đã thêm thành công sản phẩm: '.$product->name.' !');
    }

    function EditVariant($idPrd){
        $data['product']=product::find($idPrd);
        return view('backend/variant/editvariant',$data);
    }

    function PostEditVariant($idPrd, Request $r){
        $product=product::find($idPrd);
        foreach($r->variant as $key=>$value)
        {
            $vari=variant::find($key);
            $vari->price=$value;
            $vari->save();
        }
        return redirect('/admin/product')->with('thongbao','Đã sửa thành công sản phẩm: '.$product->name.' !');
    }

    function DelVariant($idVariant){
        variant:: destroy($idVariant);
        return redirect()->back()->with('thongbao','Đã xóa thành công biến thể!');
    }
}
