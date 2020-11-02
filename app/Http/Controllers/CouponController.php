<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponController extends Controller
{
    //领券页面
    public function index()
    {
        return view('coupon.index');
    }

    /**
     * 领券逻辑
     */
    public function getCoupon()
    {


        //领券
        $response = [
            'errno' => 0,
            'msg'   => 'ok'
        ];

        return $response;
    }


}
