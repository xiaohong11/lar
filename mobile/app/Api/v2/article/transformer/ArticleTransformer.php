<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\article\transformer;

class ArticleTransformer extends \app\api\foundation\Transformer
{
	public function transform(array $map)
	{
		return array('id' => $map['article_id'], 'title' => $map['title']);
	}
}

?>
