<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\article;

class ArticleRepository implements \app\contracts\repository\article\ArticleRepositoryInterface
{
	public function all($cat_id, $columns = array('*'), $size = 20, $requirement = '')
	{
		$article = \app\models\Article::where('is_open', '=', 1);

		if ($cat_id == '-1') {
			$article = $article->where('cat_id', '>', 0);
		}
		else {
			$article = $article->where('cat_id', $cat_id);
		}

		$article = $article->orderBy('add_time', 'DESC')->orderBy('article_id', 'DESC')->paginate($size, $columns)->toArray();

		foreach ($article['data'] as $key => $val) {
			$default = array('click' => 1, 'likenum' => 0, 'hatenum' => 0);
			$extend = \app\models\ArticleExtend::where('article_id', $val['id'])->first();
			unset($extend['id']);
			$article['data'][$key] = array_merge($article['data'][$key], is_null($extend) ? $default : $extend->toArray());
		}

		return $article;
	}

	public function detail($id)
	{
		if (is_array($id)) {
			$field = key($id);
			$value = $id[$field];
			$model = \app\models\Article::where($field, '=', $value)->first();
		}
		else {
			$model = \app\models\Article::find($id);
		}

		if (is_null($model)) {
			return false;
		}

		$article = $model->toArray();

		if (is_null($model->extend)) {
			$data = array('article_id' => $model->article_id, 'click' => 1, 'likenum' => 0, 'hatenum' => 0);
			\app\models\ArticleExtend::create($data);
		}
		else {
			$data = $model->extend->toArray();
			unset($data['id']);
		}

		$article = array_merge($article, $data);

		foreach ($model->comment as $vo) {
			$model->comment->push($vo->user);
		}

		$article['comment'] = $model->comment->where('id_value', '=', $id)->toArray();
		$article['goods'] = $model->goods->toArray();
		return $article;
	}

	public function create($data)
	{
		return false;
	}

	public function update($data)
	{
		return false;
	}

	public function delete($id)
	{
		return false;
	}
}

?>
