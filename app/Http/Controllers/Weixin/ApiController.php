<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
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

    /**
     * 商品列表
     */
    public function goodsList(Request $request)
    {
        //$g = GoodsModel::select('goods_id','goods_name','shop_price','goods_img')->limit(10)->get()->toArray();
        $page_size = $request->get('ps');
        $g = GoodsModel::select('goods_id','goods_name','shop_price','goods_img')->paginate($page_size);

        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => [
                'list'  => $g->items()
            ]
        ];

        return $response;

    }

    /**
     * 商品详情
     */
    public function goodsInfo(Request $request)
    {
        $id = $request->get('id');
        $g = GoodsModel::find($id);
        if($g)
        {
            //假图片
         $g->gallery = [
             '//m.360buyimg.com/mobilecms/s750x750_jfs/t1/111255/12/4798/60106/5eaf8287E07941008/3c44062730a124a3.jpg!q80.dpg.webp',
             '//m.360buyimg.com/mobilecms/s1125x1125_jfs/t1/110386/33/15773/49353/5eaf8287E3bf0ee38/f36b1e38ffa548bb.jpg!q70.dpg.webp',
             '//m.360buyimg.com/mobilecms/s1125x1125_jfs/t1/114659/16/4624/58760/5eaf8287E5990f3f2/bfb950634adec0d3.jpg!q70.dpg.webp',
             '//m.360buyimg.com/mobilecms/s1125x1125_jfs/t1/107198/29/15926/41692/5eaf8287Ecee4dff5/663bdfd096326880.jpg!q70.dpg.webp'
         ];
            $response = [
                'errno' => 0,
                'msg'   => 'ok',
                'data'  => [
                    'info'  => $g
                ]
            ];

        }else{
            $response = [
                'errno' => 400001,
                'msg'   => 'Goods Not Exist'
            ];
        }

        return $response;
    }

}
