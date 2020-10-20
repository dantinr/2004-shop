<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * 生成订单
     */
    public function add()
    {
        //TODO 获取购物车中的商品（根据当前用户id）

        //TODO 生成订单号 计算订单总价  记录订单信息（订单表orders）

        // TODO 记录订单商品  （订单商品表orders_goods）

        //TODO 清空购物车

        //TODO 跳转至 支付页面

    }
}
