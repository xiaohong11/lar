<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class TouchAd extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'touch_ad';
	protected $primaryKey = 'ad_id';
	public $timestamps = false;
	protected $fillable = array('position_id', 'media_type', 'ad_name', 'ad_link', 'link_color', 'ad_code', 'start_time', 'end_time', 'link_man', 'link_email', 'link_phone', 'click_count', 'enabled', 'is_new', 'is_hot', 'is_best', 'public_ruid', 'ad_type', 'goods_name');
	protected $guarded = array();

	public function position()
	{
		return $this->belongsTo('App\\Models\\TouchAdPosition', 'position_id', 'position_id');
	}
}

?>
