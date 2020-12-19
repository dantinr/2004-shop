<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{

    protected $table = 'order_info';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    /**
     * 与订单model的关系 one to more
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany('App\Model\OrderGoodsModel','order_id');
    }

    /**
     * 根据订单号查人
     */
    public function user()
    {
        return $this->belongsTo('App\Model\UserModel','user_id');
    }
}
