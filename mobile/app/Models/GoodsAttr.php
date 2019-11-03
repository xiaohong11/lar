<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsAttr extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_attr';
	protected $primaryKey = 'goods_attr_id';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'attr_id', 'attr_value', 'color_value', 'attr_price', 'attr_sort', 'attr_img_flie', 'attr_gallery_flie', 'attr_img_site', 'attr_checked', 'attr_value1', 'lang_flag', 'attr_img', 'attr_thumb', 'img_flag', 'attr_pid', 'admin_id');
	protected $guarded = array();
}

?>
