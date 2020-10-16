<?php

namespace App\Http\Controllers;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Model\CartModel;

class CartController extends Controller
{


    /**
     * 购物车页面
     */
    public function index()
    {
        $uid = session()->get('uid');
        if(empty($uid))
        {
            return redirect('/user/login');
        }

        //取购物车商品信息
        $list = CartModel::where(['uid'=>$uid])->get();
        //echo '<pre>';print_r($list->toArray());echo '</pre>';

        foreach($list as $k=>$v)
        {
            $goods[] = GoodsModel::find($v['goods_id'])->toArray();
        }

        echo '<pre>';print_r($goods);echo '</pre>';

        $data = [
            'goods' => $goods
        ];

        return view('cart.index',$data);



    }


    /**
     * 加入购物车
     */
    public function add(Request $request)
    {

        $uid = session()->get('uid');
        if(empty($uid))
        {
            $data = [
                'errno' => 400001,
                'msg'   => '请先登录'
            ];

            echo json_encode($data);
            die;
        }

        $goods_id = $request->get('id');
        $goods_num = $request->get('num',1);

        // 检查是否下架 库存是否充足  ...

        //购物车保存商品信息
        $cart_info = [
            'goods_id'  => $goods_id,
            'uid'       => $uid,
            'goods_num' => $goods_num,
            'add_time'  => time(),
        ];

        $res = CartModel::insertGetId($cart_info);
        if($res>0)
        {
            $data = [
                'errno' => 0,
                'msg'   => '成功加入购物车'
            ];

            echo json_encode($data);
        }else{
            $data = [
                'errno' => 500001,
                'msg'   => '加入购物车失败'
            ];

            echo json_encode($data);
        }





    }
}
