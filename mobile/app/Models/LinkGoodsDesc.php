<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class LinkGoodsDesc extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'link_goods_desc';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'desc_name', 'goods_desc');
	protected $guarded = array();
}

?>
