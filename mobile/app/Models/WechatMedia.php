<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatMedia extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_media';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'title', 'command', 'author', 'is_show', 'digest', 'content', 'link', 'file', 'size', 'file_name', 'thumb', 'add_time', 'edit_time', 'type', 'article_id', 'sort');
	protected $guarded = array();
}

?>
