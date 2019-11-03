<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SourceIp extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'source_ip';
	protected $primaryKey = 'ipid';
	public $timestamps = false;
	protected $fillable = array('storeid', 'ipdata', 'iptime');
	protected $guarded = array();
}

?>
