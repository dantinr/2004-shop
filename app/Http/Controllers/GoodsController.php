<?php

namespace App\Http\Controllers;

use App\Model\FavGoodsModel;
use Illuminate\Http\Request;
use App\Model\GoodsModel;

class GoodsController extends Controller
{




    /**
     * 商品详情
     */
    public function detail(Request $request)
    {
        $goods_id = $request->get('id');
        //echo "goods_id: ". $goods_id;die;

        $goods = GoodsModel::find($goods_id);

        //验证商品是否有效（是否存在、是否下架、是否删除）
        if(empty($goods))
        {
            return view('goods.404');       //商品不存在
        }

        //是否下架
        if($goods->is_delete==1)
        {
            return view('goods.delete');       //商品已删除
        }


        $data = [
            'g' => $goods,
        ];

        return view('goods.detail',$data);
    }


    /**
     * 商品列表
     */
    public function goodsList()
    {
        $list = GoodsModel::limit(10)->get();

        return view('goods.list',['list'=>$list]);
    }

    /**
     * 收藏商品
     */
    public function fav(Request  $request)
    {
        $uid = session()->get('uid');
        if(empty($uid))
        {
            $res = [
                'errno' => 400003,
                'msg'   => "请先登录"
            ];

            return $res;
        }

        $id = $request->get('id');

        $data = [
            'goods_id'  => $id,
            'uid'       => $uid,
            'add_time'  => time()
        ];

        FavGoodsModel::insertGetId($data);
        $res = [
            'errno' => 0,
            'msg'   => 'ok'
        ];

        return  $res;
    }
}
