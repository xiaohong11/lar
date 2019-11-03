<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class UserAccountFields extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'user_account_fields';
	public $timestamps = false;
	protected $fillable = array('user_id', 'account_id', 'bank_number', 'real_name');
	protected $guarded = array();
}

?>
