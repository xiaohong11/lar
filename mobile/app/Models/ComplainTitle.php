<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ComplainTitle extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'complain_title';
	protected $primaryKey = 'title_id';
	public $timestamps = false;
	protected $fillable = array('title_name', 'title_desc', 'is_show');
	protected $guarded = array();
}

?>
