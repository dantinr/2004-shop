<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayController extends Controller
{

    /**
     * 订单支付（支付宝）
     */
    public function aliPay(Request $request)
    {
        $oid = $request->get('oid');
        echo "订单ID: ". $oid;

        //根据订单号，查询订单信息，验证订单是否有效（未支付、未删除、未过期）

        //组合参数，调用支付接口，支付

    }


    /**
     * 支付宝异步通知
     */
    public function aliNotify()
    {
        //TODO 验签

        // TODO 验证订单状态是否有效（未支付）

        // TODO 修改订单状态（更新支付时间 支付金额）

    }


    /**
     * 微信支付
     */
    public function wxPay(){}


    /**
     * 微信支付异步通知
     */
    public function wxNotify(){}
}
