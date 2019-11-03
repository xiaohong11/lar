<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsStepsImg extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_steps_img';
	protected $primaryKey = 'gid';
	public $timestamps = false;
	protected $fillable = array('tid', 'steps_img');
	protected $guarded = array();
}

?>
