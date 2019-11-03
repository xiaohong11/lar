<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Plugins extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'plugins';
	protected $primaryKey = 'code';
	public $timestamps = false;
	protected $fillable = array('version', 'library', 'assign', 'install_date');
	protected $guarded = array();
}

?>
