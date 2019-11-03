<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsRegionArea extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_region_area';
	protected $primaryKey = 'ra_id';
	public $timestamps = false;
	protected $fillable = array('ra_name', 'ra_sort', 'add_time', 'up_titme');
	protected $guarded = array();
}

?>
