<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Article extends \Illuminate\Database\Eloquent\Model
{
	/**
     * @var string
     */
	protected $table = 'article';
	/**
     * @var string
     */
	protected $primaryKey = 'article_id';
	/**
     * @var bool
     */
	public $timestamps = false;
	/**
     * @var array
     */
	protected $hidden = array('article_id', 'cat_id', 'is_open', 'open_type', 'author_email', 'article_type');
	/**
     * @var array
     */
	protected $visible = array();
	/**
     * @var array
     */
	protected $appends = array('id', 'url', 'album', 'amity_time');
	/**
     * @var array
     */
	protected $fillable = array('cat_id', 'title', 'content', 'author', 'author_email', 'keywords', 'article_type', 'is_open', 'add_time', 'file_url', 'open_type', 'link', 'description');
	/**
     * @var array
     */
	protected $guarded = array();

	public function extend()
	{
		return $this->hasOne('app\\models\\ArticleExtend', 'article_id', 'article_id');
	}

	public function comment()
	{
		return $this->hasMany('app\\models\\Comment', 'id_value', 'article_id');
	}

	public function goods()
	{
		return $this->belongsToMany('app\\models\\Goods', 'goods_article', 'article_id', 'goods_id');
	}

	public function getAddTimeAttribute()
	{
		return local_date('Y-m-d', $this->attributes['add_time']);
	}

	public function getAmityTimeAttribute()
	{
		return friendlyDate($this->attributes['add_time'], 'moremohu');
	}

	public function getIdAttribute()
	{
		return $this->attributes['article_id'];
	}

	public function getAlbumAttribute()
	{
		$pattern = '/<[img|IMG].*?src=[\\\'|"](.*?(?:[\\.gif|\\.jpg|\\.png|\\.bmp|\\.jpeg]))[\\\'|"].*?[\\/]?>/';
		preg_match_all($pattern, $this->attributes['content'], $match);
		$album = array();

		if (0 < count($match[1])) {
			foreach ($match[1] as $img) {
				if (strtolower(substr($img, 0, 4)) != 'http') {
					$realpath = mb_substr($img, stripos($img, 'images/'));
					$album[] = get_image_path($realpath);
				}
			}
		}

		if (3 < count($album)) {
			$album = array_slice($album, 0, 3);
		}

		return $album;
	}

	public function getUrlAttribute()
	{
		return url('article/index/detail', array('id' => $this->attributes['article_id']));
	}
}

?>
