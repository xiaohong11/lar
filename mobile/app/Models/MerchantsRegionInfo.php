<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsRegionInfo extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_region_info';
	public $timestamps = false;
	protected $fillable = array('ra_id', 'region_id');
	protected $guarded = array();
}

?>
