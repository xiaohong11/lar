<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerShopslide extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_shopslide';
	public $timestamps = false;
	protected $fillable = array('ru_id', 'img_url', 'img_link', 'img_desc', 'img_order', 'slide_type', 'is_show', 'seller_theme', 'install_img');
	protected $guarded = array();
}

?>
