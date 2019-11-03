<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ShopConfig extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'shop_config';
	public $timestamps = false;
	protected $fillable = array('parent_id', 'code', 'type', 'store_range', 'store_dir', 'value', 'sort_order', 'shop_group');
	protected $guarded = array();
}

?>
