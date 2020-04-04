<?php
function showErrors($errors,$name){
    if ($errors->has($name)){
        echo '<div class="alert alert-danger" role="alert">';
        echo '<strong>'.$errors->first($name).'</strong>';
        echo '</div>';
    }
}

function GetCate($arr,$parent,$shift,$active){
    foreach($arr as $row){
        if($row['parent']==$parent){
            if($row->id==$active){
                echo "<option selected value='$row->id'>".$shift.$row['name'].'</option>';
            }else{
                echo "<option value='$row->id'>".$shift.$row['name'].'</option>';
            }

            GetCate($arr,$row['id'],$shift.'--|',$active);
        }
    }
}

function ShowCate($arr,$parent,$shift){
    foreach($arr as $row){
        if($row['parent']==$parent){
            echo "<div class='item-menu'><span>".$shift.$row['name']."</span>
            <div class='category-fix'>
                <a class='btn-category btn-primary' href='/admin/category/edit/".$row->id."'><i class='fa fa-edit'></i></a>
                <a onclick='return del(\" $row->name \")' class='btn-category btn-danger' href='/admin/category/del/".$row->id."'><i class='fas fa-times'></i></i></a>
            </div>
        </div>";

            ShowCate($arr,$row['id'],$shift.'--|');

        }
    }
}


//input: $mang=$product->$values   output: array('size'=>array(s,m),'color'=>array(Đỏ,Xanh))
function attr_values($mang)
{
    $result = array();
    foreach($mang as $value){
        $attr=$value->attribute->name;
        $result[$attr][]=$value->value;
    }
    return $result;
}


function get_combinations($arrays)
{
    $result=array(array());
    foreach($arrays as $property => $property_values){
        $tmp=array();
        foreach($result as $result_item){
            foreach($property_values as $property_value){
                $tmp[]=array_merge($result_item, array($property => $property_value));
            }
        }
        $result=$tmp;
    }
    return $result;
}


function check_value($product,$value_check)
{
    foreach ($product->values as $value) {
        if($value->id==$value_check){
            return true;
        }
    }
    return false;
}

function check_variant($product,$array){
    foreach($product->variant as $row){
        $mang=array();
        foreach ($row->values as $value) {
            $mang[]=$value->id;
        }

        if(array_diff($mang,$array)==null){
            return false;
        }
    }
    return true;
}

function getprice($product,$array)
{
    foreach($product->variant as $row)
    {
        $mang= array();
        foreach($row->values as $value)
        {
            $mang[]=$value->value;
        }
        if(array_diff($mang,$array)==null)
        {
            if($row->price==0)
            {
                return $product->price;
            }
            return $row->price;
        }
    }
    return $product->price;
}
