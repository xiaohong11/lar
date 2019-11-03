<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class UserGiftGard extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'user_gift_gard';
	protected $primaryKey = 'gift_gard_id';
	public $timestamps = false;
	protected $fillable = array('gift_sn', 'gift_password', 'user_id', 'goods_id', 'user_time', 'express_no', 'gift_id', 'address', 'consignee_name', 'mobile', 'status', 'config_goods_id', 'is_delete', 'shipping_time');
	protected $guarded = array();
}

?>
