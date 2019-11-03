<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Agency extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'agency';
	protected $primaryKey = 'agency_id';
	public $timestamps = false;
	protected $fillable = array('agency_name', 'agency_desc');
	protected $guarded = array();
}

?>
