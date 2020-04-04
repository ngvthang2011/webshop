<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use DB;
use App\models\{users,customer};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    function GetLogin(){
        return view('backend.login.login');
    }

    function PostLogin(LoginRequest $r){

        $count = users::where('email',$r->email)->where('password',$r->password)->count();
        if(Auth::attempt(['email' => $r->email, 'password' => $r->password])){

            return redirect('admin');
        }else{
            return redirect('login')->withInput()->with('thongbao','Tài khoản hoặc mật khẩu không chính xác');
        }
    }

    function Logout(){
        Auth::logout();
        return redirect('login');
    }

    function GetIndex(){
        $year_now=Carbon::now()->format('Y');
        $month_now=Carbon::now()->format('m');
        for($i=1;$i<=$month_now;$i++){
            $months[$i]='Tháng '.$i;
            $numbers[$i]=customer::where('state',1)->whereMonth('updated_at',$i)->whereYear('updated_at',$year_now)->sum('total');
        }
        $data['months']=$months;
        $data['numbers']=$numbers;
        $data['order']=customer::where('state',1)->count();
        return view('backend.index',$data);
    }
}
