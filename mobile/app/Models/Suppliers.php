<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Suppliers extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'suppliers';
	protected $primaryKey = 'suppliers_id';
	public $timestamps = false;
	protected $fillable = array('suppliers_name', 'suppliers_desc', 'is_check');
	protected $guarded = array();
}

?>
