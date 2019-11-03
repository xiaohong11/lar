<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class TeamGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'team_goods';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'team_price', 'team_num', 'validity_time', 'limit_num', 'astrict_num', 'tc_id', 'is_audit', 'is_team', 'sort_order');
	protected $guarded = array();
}

?>
