<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class LinkAreaGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'link_area_goods';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'region_id', 'ru_id');
	protected $guarded = array();
}

?>
