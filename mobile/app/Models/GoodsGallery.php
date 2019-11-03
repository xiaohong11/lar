<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsGallery extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_gallery';
	protected $primaryKey = 'img_id';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'img_url', 'img_desc', 'thumb_url', 'img_original', 'single_id', 'external_url', 'front_cover', 'dis_id');
	protected $guarded = array();
}

?>
