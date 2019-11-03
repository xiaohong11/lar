<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GalleryAlbum extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'gallery_album';
	protected $primaryKey = 'album_id';
	public $timestamps = false;
	protected $fillable = array('ru_id', 'album_mame', 'album_cover', 'album_desc', 'sort_order', 'add_time');
	protected $guarded = array();
}

?>
