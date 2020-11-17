<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function __construct()
    {
        app('debugbar')->disable();     //关闭调试
    }

    public function userInfo()
    {
        echo __METHOD__;
    }

    public function test()
    {

        $goods_info = [
            'goods_id'  => 13345,
            'goods_name'    => "IPHONE",
            'price'     => 12.34
        ];

        echo json_encode($goods_info);

    }
}
