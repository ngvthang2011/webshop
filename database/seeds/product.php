<?php

use Illuminate\Database\Seeder;

class product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->delete();
        DB::table('product')->insert([
            ['id'=>1,'product_code'=>'SP1','name'=>'Áo nam da thật MX105','price'=>50000,'featured'=>1,'state'=>0,'img'=>'no-img.jpg','category_id'=>2],
            ['id'=>2,'product_code'=>'SP2','name'=>'Áo thun có cổ','price'=>50000,'featured'=>1,'state'=>1,'img'=>'no-img.jpg','category_id'=>2],
            ['id'=>3,'product_code'=>'SP3','name'=>'Quần âu nam','price'=>50000,'featured'=>0,'state'=>0,'img'=>'no-img.jpg','category_id'=>3],
            ['id'=>4,'product_code'=>'SP4','name'=>'Áo nữ cổ V viền tay xinh xắn','price'=>50000,'featured'=>1,'state'=>1,'img'=>'no-img.jpg','category_id'=>6],
            ['id'=>5,'product_code'=>'SP5','name'=>'Quần nữ xuông ống rộng','price'=>50000,'featured'=>0,'state'=>1,'img'=>'no-img.jpg','category_id'=>7],
        ]);
    }
}
