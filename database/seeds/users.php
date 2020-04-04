<?php

use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            ['id'=>1,'email'=>'admin@gmail.com','password'=>bcrypt('123456'),'full'=>'Nguyễn Thắng','address'=>'Hà Nội','phone'=>'0339054040','level'=>1],
            ['id'=>2,'email'=>'khai@gmail.com','password'=>bcrypt('123456'),'full'=>'Nguyễn Quang Khải ','address'=>'Hà Tây','phone'=>'0559054040','level'=>2],
            ['id'=>3,'email'=>'phat@gmail.com','password'=>bcrypt('123456'),'full'=>'Nguyễn Tiến Phát','address'=>'Chương Mỹ','phone'=>'0339054045','level'=>1],
            ['id'=>4,'email'=>'son@gmail.com','password'=>bcrypt('123456'),'full'=>'Nguyễn Trường Sơn','address'=>'Ninh Bình','phone'=>'0339054090','level'=>2],
        ]);
    }
}
