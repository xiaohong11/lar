<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\custom\guestbook\controllers;

class Index extends \app\http\base\controllers\Frontend
{
	public function actionIndex()
	{
		echo 'this guestbook list. ';
		echo '<a href="' . url('add') . '">Goto Add</a>';
	}

	public function actionAdd()
	{
		$this->display();
	}

	public function actionSave()
	{
		$post = array('title' => I('title'), 'content' => I('content'));
		$this->redirect('index');
	}
}

?>
