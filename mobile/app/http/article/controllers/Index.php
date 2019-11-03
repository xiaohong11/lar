<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\http\article\controllers;

class Index extends \app\http\base\controllers\Frontend
{
	protected $category;
	protected $article;

	public function __construct(\app\repositories\article\CategoryRepository $category, \app\repositories\article\ArticleRepository $article)
	{
		parent::__construct();
		L(require LANG_PATH . C('shop.lang') . '/user.php');
		$this->category = $category;
		$this->article = $article;
	}

	public function actionIndex()
	{
		if (IS_AJAX) {
			$cat = dao('article_cat')->field('cat_id')->where(array('cat_type' => 1, 'parent_id' => 0))->getField();
			$cat_id = I('post.cat_id', $cat, 'intval');
			$result = $this->article->all($cat_id, array('*'), 10);
			$article = $result['data'];

			foreach ($article as $key => $value) {
				$article[$key]['likenum'] = $value['likenum'];
				$article[$key]['click'] = !empty($value['click']) ? $value['click'] : 0;

				if (count($article[$key]['album']) == 0) {
					$article[$key]['imgNumPattern'] = 0;
				}
				else {
					if ((count($article[$key]['album']) == 1) || (count($article[$key]['album']) == 2)) {
						$article[$key]['imgNumPattern'] = 1;
					}
					else {
						$article[$key]['imgNumPattern'] = 2;
					}
				}
			}

			$num = ceil(count($article) / 10);
			$this->response(array('list' => $article, 'totalPage' => $num), 'json', 200);
		}

		$category = $this->category->all(array('cat_type' => 1));
		$this->assign('page_title', lang('文章频道'));
		$this->assign('data', $category['data']);
		$this->display('index.index');
	}

	public function actionDetail($id)
	{
		$article = $this->article->detail($id);
		$this->assign('page_title', lang('文章详情'));

		foreach ($article['comment'] as $key => $value) {
			$article['comment'][$key]['add_time'] = date('Y-m-d H:i:s', $value['add_time']);
			$article['comment'][$key]['user']['user_picture'] = get_image_path($value['user']['user_picture']);
		}

		$this->assign('article', $article);

		if (!empty($article['file_url'])) {
			$article_img = get_wechat_image_path($article['file_url']);
		}
		else {
			$article_img = $article['album'][0];
		}

		$share_data = array('title' => $article['title'], 'desc' => $article['description'], 'link' => '', 'img' => $article_img);
		$this->assign('share_data', $this->get_wechat_share_content($share_data));
		$this->display('index.detail');
	}

	public function actionView()
	{
		$article_id = I('id', 0, 'intval');

		if (IS_AJAX) {
			dao('article_extend')->where(array('article_id' => $article_id))->setInc('click', '1');
			$view_num = dao('article_extend')->where(array('article_id' => $article_id))->getField('click');
			echo json_encode(array('view_num' => $view_num, 'is_like' => 0, 'article_id' => $article_id));
		}
	}

	public function actionLike()
	{
		$article_id = I('id', 0, 'intval');

		if (IS_AJAX) {
			if ($_COOKIE[$article_id . 'islike'] == '1') {
				dao('article_extend')->where(array('article_id' => $article_id))->setInc('likenum', '-1');
				$like_num = dao('article_extend')->where(array('article_id' => $article_id))->getField('likenum');
				setcookie($article_id . 'islike', '0', gmtime() - 86400);
				echo json_encode(array('like_num' => $like_num, 'is_like' => 0, 'article_id' => $article_id));
			}
			else {
				dao('article_extend')->where(array('article_id' => $article_id))->setInc('likenum', '1');
				$like_num = dao('article_extend')->where(array('article_id' => $article_id))->getField('likenum');
				setcookie($article_id . 'islike', '1', gmtime() + 86400);
				echo json_encode(array('like_num' => $like_num, 'is_like' => 1, 'article_id' => $article_id));
			}
		}
	}

	public function actionComment($id)
	{
		if (I('content')) {
			$user_id = $_SESSION['user_id'];
			$user_name = $_SESSION['user_name'];
			$user_ip = $_SERVER['REMOTE_ADDR'];
			$parent_id = (I('cid') ? I('cid') : 0);

			if (!empty($user_id)) {
				$article_id = I('id');

				if (IS_POST) {
					$data['content'] = I('content');
					$data['user_id'] = $user_id;
					$data['user_name'] = $user_name;
					$data['id_value'] = $id;
					$data['comment_type'] = '1';
					$data['parent_id'] = $parent_id;
					$data['status'] = '1';
					$data['add_time'] = gmtime();
					$data['ip_address'] = $user_ip;

					if (!empty($data['content'])) {
						$res = $this->model->table('comment')->data($data)->add();

						if ($res == true) {
							echo json_encode(url('article/index/detail', array('id' => $id)));
						}
					}
				}
			}
			else {
				echo json_encode(url('user/login/index'));
			}
		}
	}

	public function actionWechat()
	{
		if (is_dir(APP_WECHAT_PATH)) {
			$news_id = I('get.id', 0, 'intval');
			$data = $this->db->table('wechat_media')->field('wechat_id,title,author,add_time,is_show, file, digest, content')->where(array('id' => $news_id))->find();

			if (empty($data)) {
				$this->redirect('/');
			}

			$data['author'] = !empty($data['author']) ? $data['author'] : $this->db->table('wechat')->where(array('id' => $data['wechat_id']))->getField('name');
			$data['add_time'] = local_date('Y-m-d H:i', $data['add_time']);
			$data['content'] = article_content_html_out($data['content']);
			$share_data = array('title' => $data['title'], 'desc' => strip_tags($data['digest']), 'link' => '', 'img' => get_wechat_image_path($data['file']));
			$this->assign('share_data', $this->get_wechat_share_content($share_data));
			$this->assign('page_title', $data['title']);
			$this->assign('description', strip_tags($data['digest']));
			$this->assign('article', $data);
		}

		$this->display();
	}

	private function parameter()
	{
		$page_size = C('shop.article_number');
		$this->parameter['size'] = 0 < $page_size ? $page_size : 10;
		$this->parameter['page'] = I('page') ? I('page', 'intval') : 1;
		$this->parameter['cat_id'] = I('id', 'intval');
		$this->parameter['keywords'] = I('keywords');
	}

	public function actionComments($id)
	{
		$article = $this->article->detail($id);
		$this->assign('page_title', lang('文章详情'));

		foreach ($article['comment'] as $key => $value) {
			$article['comment'][$key]['add_time'] = date('Y-m-d H:i:s', $value['add_time']);
			$article['comment'][$key]['user']['user_picture'] = get_image_path($value['user']['user_picture']);
		}

		$this->assign('article', $article);
		$this->display('index.comments');
	}
}

?>
