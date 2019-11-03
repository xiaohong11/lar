<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\category;

class CategoryRepository implements \app\contracts\repository\category\CategoryRepositoryInterface
{
	public function getAllCategorys()
	{
		$category_list = cache('category_list');

		if (empty($category_list)) {
			$category_list = $this->getTree(0);
			cache('category_list', $category_list, array('expire' => 3600));
		}

		return $category_list;
	}

	public function getCategoryGetGoods($id)
	{
		$goods = \app\models\Goods::select('goods_id', 'goods_sn', 'goods_name')->where('cat_id', $id)->get()->toArray();
		return $goods;
	}

	private function getTree($tree_id = 0, $top = 0)
	{
		$three_arr = array();
		$count = \app\models\Category::where('parent_id', $tree_id)->where('is_show', 1)->count();
		if ((0 < $count) || ($tree_id == 0)) {
			$res = \app\models\Category::select('cat_id', 'cat_name', 'touch_icon', 'parent_id', 'cat_alias_name', 'is_show')->where('parent_id', $tree_id)->where('is_show', 1)->with(array('goods' => function($query) {
				$query->select('goods_thumb')->where('is_on_sale', 1)->where('is_delete', 0)->orderby('sort_order', 'ASC')->orderby('goods_id', 'DESC')->limit(1);
			}))->orderby('sort_order', 'ASC')->orderby('cat_id', 'ASC')->get()->toArray();

			foreach ($res as $k => $row) {
				if ($row['is_show']) {
					$three_arr[$k]['id'] = $row['cat_id'];
					$three_arr[$k]['name'] = $row['cat_alias_name'] ? $row['cat_alias_name'] : $row['cat_name'];
					$three_arr[$k]['cat_img'] = !empty($row['touch_icon']) ? get_image_path($row['touch_icon']) : get_image_path($row['goods_thumb']);
					$three_arr[$k]['haschild'] = 0;
				}

				if (isset($row['cat_id'])) {
					$child_tree = $this->getTree($row['cat_id']);

					if ($child_tree) {
						$three_arr[$k]['cat_id'] = $child_tree;
						$three_arr[$k]['haschild'] = 1;
					}
				}
			}
		}

		return $three_arr;
	}
}

?>
