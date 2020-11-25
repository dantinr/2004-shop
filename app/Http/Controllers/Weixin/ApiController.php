<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use App\Model\CartModel;
use App\Model\GoodsDescImgModel;
use App\Model\GoodsModel;
use App\Model\WxUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
            'goods_id' => 13345,
            'goods_name' => "IPHONE",
            'price' => 12.34
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
        $g = GoodsModel::select('goods_id', 'goods_name', 'shop_price', 'goods_img')->paginate($page_size);

        $response = [
            'errno' => 0,
            'msg' => 'ok',
            'data' => [
                'list' => $g->items()
            ]
        ];

        return $response;

    }

    /**
     * 商品详情
     */
    public function goodsInfo(Request $request)
    {
        $token = $request->get('access_token');
        //验证token是否有效
        $token_key = 'h:xcx:login:' . $token;
        //检查key是否存在
        $status = Redis::exists($token_key);

        if ($status == 0) {
            $response = [
                'errno' => 400003,
                'msg' => "未授权"
            ];
            return $response;
        }


        $id = $request->get('id');
        $g = GoodsModel::find($id);
        if ($g) {

            //商品描述图片
            $desc_img = GoodsDescImgModel::select('src')->where(['goods_id' => 217])->get()->toArray();
            $g->desc_img = array_column($desc_img, 'src');

            //假图片 商品相册
            $g->gallery = [
                '//m.360buyimg.com/mobilecms/s750x750_jfs/t1/111255/12/4798/60106/5eaf8287E07941008/3c44062730a124a3.jpg!q80.dpg.webp',
                '//m.360buyimg.com/mobilecms/s1125x1125_jfs/t1/110386/33/15773/49353/5eaf8287E3bf0ee38/f36b1e38ffa548bb.jpg!q70.dpg.webp',
                '//m.360buyimg.com/mobilecms/s1125x1125_jfs/t1/114659/16/4624/58760/5eaf8287E5990f3f2/bfb950634adec0d3.jpg!q70.dpg.webp',
                '//m.360buyimg.com/mobilecms/s1125x1125_jfs/t1/107198/29/15926/41692/5eaf8287Ecee4dff5/663bdfd096326880.jpg!q70.dpg.webp'
            ];

            $response = [
                'errno' => 0,
                'msg' => 'ok',
                'data' => [
                    'info' => $g
                ]
            ];

        } else {
            $response = [
                'errno' => 400001,
                'msg' => 'Goods Not Exist'
            ];
        }

        return $response;
    }

    /**
     * 加入购物车
     */
    public function addCart()
    {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';
    }

    /**
     * 小程序首页登录
     * @param Request $request
     */
    public function homeLogin(Request $request)
    {
        //接收code
        $code = $request->get('code');

        //使用code
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . env('WX_XCX_APPID') . '&secret=' . env('WX_XCX_SECRET') . '&js_code=' . $code . '&grant_type=authorization_code';

        $data = json_decode(file_get_contents($url), true);

        //自定义登录状态
        if (isset($data['errcode']))     //有错误
        {
            $response = [
                'errno' => 50001,
                'msg' => '登录失败',
            ];

        } else {              //成功
            $openid = $data['openid'];          //用户OpenID
            //判断新用户 老用户
            $u = WxUserModel::where(['openid' => $openid])->first();
            if ($u) {
                // TODO 老用户
                $uid = $u->id;
                //更新用户信息

            } else {
                // TODO 新用户
                $u_info = [
                    'openid' => $openid,
                    'add_time' => time(),
                    'type' => 3        //小程序
                ];

                $uid = WxUserModel::insertGetId($u_info);
            }

            //生成token
            $token = sha1($data['openid'] . $data['session_key'] . mt_rand(0, 999999));
            //保存token
            $redis_login_hash = 'h:xcx:login:' . $token;

            $login_info = [
                'uid' => $uid,
                'user_name' => "",
                'login_time' => date('Y-m-d H:i:s'),
                'login_ip' => $request->getClientIp(),
                'token' => $token,
                'openid'    => $openid
            ];

            //保存登录信息
            Redis::hMset($redis_login_hash, $login_info);
            // 设置过期时间
            Redis::expire($redis_login_hash, 7200);

            $response = [
                'errno' => 0,
                'msg' => 'ok',
                'data' => [
                    'token' => $token
                ]
            ];
        }

        return $response;

    }

    /**
     * 小程序 个人中心登录
     * @param Request $request
     * @return array
     */
    public function userLogin(Request $request)
    {
        //接收code
        //$code = $request->get('code');
        $token = $request->get('token');

        //获取用户信息
        $userinfo = json_decode(file_get_contents("php://input"), true);

        $redis_login_hash = 'h:xcx:login:' . $token;
        $openid = Redis::hget($redis_login_hash, 'openid');          //用户OpenID

        $u0 = WxUserModel::where(['openid' => $openid])->first();
        if($u0->update_time == 0){     // 未更新过资料
            //因为用户已经在首页登录过 所以只需更新用户信息表
            $u_info = [
                'nickname' => $userinfo['u']['nickName'],
                'sex' => $userinfo['u']['gender'],
                'language' => $userinfo['u']['language'],
                'city' => $userinfo['u']['city'],
                'province' => $userinfo['u']['province'],
                'country' => $userinfo['u']['country'],
                'headimgurl' => $userinfo['u']['avatarUrl'],
                'update_time'   => time()
            ];
            WxUserModel::where(['openid' => $openid])->update($u_info);
        }

        $response = [
            'errno' => 0,
            'msg' => 'ok',
        ];

        return $response;

    }

    /**
     * 小程序购物车列表
     */
    public function cartList()
    {
        $uid = 3829;
        $goods = CartModel::where(['uid'=>$uid])->get();
        if($goods)      //购物车有商品
        {
            $goods = $goods->toArray();
            foreach($goods as $k=>&$v)
            {
                $g = GoodsModel::find($v['goods_id']);
                $v['goods_name'] = $g->goods_name;
            }
        }else{          //购物车无商品
            $goods = [];
        }

        //echo '<pre>';print_r($goods);echo '</pre>';die;
        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => [
                'list'  => $goods
            ]
        ];

        return $response;
    }

    public function test111()
    {
        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => [
                'u' => [],
                'goods' => []
            ]
        ];

        return $response;
    }


}
