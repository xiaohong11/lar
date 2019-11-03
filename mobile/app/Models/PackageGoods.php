<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class PackageGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'package_goods';
	public $timestamps = false;
	protected $fillable = array('package_id', 'goods_id', 'product_id', 'goods_number', 'admin_id');
	protected $guarded = array();
}

?>
