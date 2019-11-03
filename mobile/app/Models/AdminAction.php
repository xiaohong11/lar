<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class AdminAction extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'admin_action';
	protected $primaryKey = 'action_id';
	public $timestamps = false;
	protected $fillable = array('parent_id', 'action_code', 'relevance', 'seller_show');
	protected $guarded = array();
}

?>
