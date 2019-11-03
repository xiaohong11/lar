<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class TouchPageView extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'touch_page_view';
	public $timestamps = true;
	protected $fillable = array('ru_id', 'type', 'page_id', 'title', 'keywords', 'description', 'data', 'pic', 'thumb_pic', 'create_at', 'update_at', 'default', 'review_status', 'is_show');
	protected $guarded = array();
}

?>
