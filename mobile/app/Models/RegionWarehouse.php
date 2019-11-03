<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class RegionWarehouse extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'region_warehouse';
	protected $primaryKey = 'region_id';
	public $timestamps = false;
	protected $fillable = array('regionId', 'parent_id', 'region_name', 'region_type', 'agency_id');
	protected $guarded = array();
}

?>
