<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Model\OrderModel;
use App\Model\UserModel;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function search()
    {
        return view('order.search');
    }

    /**
     * 根据订单号 搜索订单详情
     */
    public function searchDo(Request $request)
    {
        $uid = $request->get('uid');
        $oid = $request->get('oid');
        $order_sn = $request->get('order_sn');
        $user_name = $request->get('user_name');

        //根据 用户名查找 订单详情
        $list = UserModel::where(['user_name'=>$user_name])->first()->orders;
        if($list){
            echo '<pre>';print_r($list->toArray());echo '</pre>';
        }else{
            echo "Nothing";
        }
        die;


        //根据 用户名查找 订单
        $list = UserModel::where(['user_name'=>$user_name])->first()->orders;
        if($list){
            echo '<pre>';print_r($list->toArray());echo '</pre>';
        }else{
            echo "Nothing";
        }
        die;




        //根据订order_sn 查 订单详情
        $list = OrderModel::where(['order_sn'=>$order_sn])->first()->orderDetails;
        if($list){
            echo '<pre>';print_r($list->toArray());echo '</pre>';
        }else{
            echo "Nothing";
        }
        die;


        //根据订单号 查 人 begin
        $u = OrderModel::find($oid)->user;
        if($u){
            echo '<pre>';print_r($u->toArray());echo '</pre>';
        }else{
            echo "Nothing";
        }
        die;

        //根据订单号 查 人 end


        //根据用户查订单 begin
        $list = UserModel::find($uid)->orders;
        if($list){
            $list = $list->toArray();
            echo '<pre>';print_r($list);echo '</pre>';
        }else{
            echo "Nothing";
        }
        //根据用户查订单 end

        //根据订单 查 订单详情 begin

        $details = OrderModel::find($oid)->orderDetails;
        if($details){
            $list = $details->toArray();
            echo '<pre>';print_r($list);echo '</pre>';
        }else{
            echo "Nothing";
        }
        //根据订单 查 订单详情 end
    }
}
