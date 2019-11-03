<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Region extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'region';
	protected $primaryKey = 'region_id';
	public $timestamps = false;
	protected $fillable = array('parent_id', 'region_name', 'region_type', 'agency_id');
	protected $guarded = array();
}

?>
