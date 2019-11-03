<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ImMessage extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'im_message';
	public $timestamps = false;
	protected $fillable = array('from_user_id', 'to_user_id', 'dialog_id', 'message', 'add_time', 'user_type', 'status');
	protected $guarded = array();
}

?>
