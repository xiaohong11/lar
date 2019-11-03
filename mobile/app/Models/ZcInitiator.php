<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ZcInitiator extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'zc_initiator';
	public $timestamps = false;
	protected $fillable = array('name', 'company', 'img', 'intro', 'describe', 'rank');
	protected $guarded = array();
}

?>
