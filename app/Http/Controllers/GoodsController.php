<?php

namespace App\Http\Controllers;

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
        //echo "goods_id: ". $goods_id;

        $goods = GoodsModel::find($goods_id);

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
}
