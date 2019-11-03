<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MailTemplates extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'mail_templates';
	protected $primaryKey = 'template_id';
	public $timestamps = false;
	protected $fillable = array('template_code', 'is_html', 'template_subject', 'template_content', 'last_modify', 'last_send', 'type');
	protected $guarded = array();
}

?>
