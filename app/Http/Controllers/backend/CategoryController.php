<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{AddCategoryRequest,EditCategoryRequest};
use App\models\category;

class CategoryController extends Controller
{
    function GetCategory(){
        $data['category']=category::all();
        return view('backend/category/category',$data);
    }

    function PostAddCategory(AddCategoryRequest $r){
        $cate=new category;
        $cate->name=$r->name;
        $cate->parent=$r->parent;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã thêm danh mục thành công!');
    }

    function EditCategory($IdCate){
        $data['cate']=category::find($IdCate);
        $data['category']=category::all();
        return view('backend/category/editcategory',$data);
    }

    function PostEditCategory(EditCategoryRequest $r,$IdCate){
        $cate=category::find($IdCate);
        $cate->name=$r->name;
        $cate->parent=$r->parent;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã Sửa thành công!');
    }

    function DelCategory($IdCate){
        $cate=Category::find($IdCate);
        Category::where('parent',$cate->id)->update(['parent'=>$cate->parent]);
        $cate->delete();
        //category::destroy($IdCate);
        return redirect()->back()->with('thongbao','Đã xóa thành công!');
    }
}
