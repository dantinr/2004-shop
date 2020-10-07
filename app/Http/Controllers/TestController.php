<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function hello()
    {
        echo "hello world";
    }


    public function sql1()
    {
        //$users = DB::table('p_users')->limit(3)->get();
        //$u = DB::table('p_users')->where(['user_name'=>'rush1987'])->first();
        //$u = DB::table('p_users')->where(['user_id'=>31])->pluck('user_name');
        $count = DB::table('p_users')->count();
        $u = DB::table('p_users')->select('user_id','user_name','password')->where(['user_id'=>5])->first();
        echo '<pre>';print_r($u);echo '</pre>';

    }
}
