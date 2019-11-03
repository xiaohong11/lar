<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Migrations extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'migrations';
	public $timestamps = false;
	protected $fillable = array('migration', 'batch');
	protected $guarded = array();
}

?>
