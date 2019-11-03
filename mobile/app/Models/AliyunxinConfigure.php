<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class AliyunxinConfigure extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'aliyunxin_configure';
	public $timestamps = false;
	protected $fillable = array('temp_id', 'temp_content', 'add_time', 'set_sign', 'send_time', 'signature');
	protected $guarded = array();
}

?>
