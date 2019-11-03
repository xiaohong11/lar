<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\contracts\repository\article;

interface ArticleRepositoryInterface
{
	public function all($cat_id, $columns, $size, $requirement);

	public function detail($id);

	public function create($data);

	public function update($data);

	public function delete($id);
}


?>
