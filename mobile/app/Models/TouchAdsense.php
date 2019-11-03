<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class TouchAdsense extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'touch_adsense';
	public $timestamps = false;
	protected $fillable = array('from_ad', 'referer', 'clicks');
	protected $guarded = array();
}

?>
