<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ComplaintTalk extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'complaint_talk';
	protected $primaryKey = 'talk_id';
	public $timestamps = false;
	protected $fillable = array('complaint_id', 'talk_member_id', 'talk_member_name', 'talk_member_type', 'talk_content', 'talk_state', 'admin_id', 'talk_time', 'view_state');
	protected $guarded = array();
}

?>
