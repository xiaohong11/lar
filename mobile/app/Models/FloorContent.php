<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class FloorContent extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'floor_content';
	protected $primaryKey = 'fb_id';
	public $timestamps = false;
	protected $fillable = array('filename', 'region', 'id_name', 'brand_id', 'brand_name', 'theme');
	protected $guarded = array();
}

?>
