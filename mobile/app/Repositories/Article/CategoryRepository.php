<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\article;

class CategoryRepository implements \app\contracts\repository\article\CategoryRepositoryInterface
{
	public function all($cat_id, $columns = array('*'), $size = 100)
	{
		if (is_array($cat_id)) {
			$field = key($cat_id);
			$value = $cat_id[$field];
			$model = \app\models\ArticleCat::where($field, '=', $value);
		}
		else {
			$model = \app\models\ArticleCat::where('parent_id', $cat_id);
		}

		return $model->orderBy('sort_order')->orderBy('cat_id')->paginate($size, $columns)->toArray();
	}

	public function detail($cat_id, $columns = array('*'))
	{
		if (is_array($cat_id)) {
			$field = key($cat_id);
			$value = $cat_id[$field];
			$model = \app\models\ArticleCat::where($field, '=', $value)->first($columns);
		}
		else {
			$model = \app\models\ArticleCat::find($cat_id, $columns);
		}

		return $model->toArray();
	}

	public function create(array $data)
	{
		return false;
	}

	public function update(array $data)
	{
		return false;
	}

	public function delete($id)
	{
		return false;
	}
}

?>
