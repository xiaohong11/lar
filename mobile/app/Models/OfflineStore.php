<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class OfflineStore extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'offline_store';
	public $timestamps = false;
	protected $fillable = array('ru_id', 'stores_user', 'stores_pwd', 'stores_name', 'country', 'province', 'city', 'district', 'stores_address', 'stores_tel', 'stores_opening_hours', 'stores_traffic_line', 'stores_img', 'is_confirm', 'add_time', 'ec_salt');
	protected $guarded = array();
}

?>
