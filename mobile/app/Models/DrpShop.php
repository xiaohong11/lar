<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class DrpShop extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'drp_shop';
	public $timestamps = false;
	protected $fillable = array('user_id', 'shop_name', 'real_name', 'mobile', 'qq', 'shop_img', 'cat_id', 'create_time', 'isbuy', 'audit', 'status', 'shop_money', 'shop_points', 'type');
	protected $guarded = array();
}

?>
