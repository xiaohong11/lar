<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerShopwindow extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_shopwindow';
	public $timestamps = false;
	protected $fillable = array('win_type', 'win_goods_type', 'win_order', 'win_goods', 'win_name', 'win_color', 'win_img', 'win_img_link', 'ru_id', 'is_show', 'win_custom', 'seller_theme');
	protected $guarded = array();
}

?>
