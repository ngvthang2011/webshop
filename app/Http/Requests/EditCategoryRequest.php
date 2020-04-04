<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|min:3|unique:category,name,'.$this->IdCate.',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Tên danh mục không được để trống',
            'name.min'=>'Tên danh mục không được ít hơn 3 kí tự',
            'name.unique'=>'Tên danh mục không được trùng',
        ];
    }
}
