<?php
// +----------------------------------------------------------------------
// | 点迈软件系统 [ DM299 ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2018 苏州点迈软件系统有限公司 [ http://www.dm299.com ]
// +----------------------------------------------------------------------
// | 官方网站：http://dm299.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | 作者: 周志华 <124861234@qq.com>
// +----------------------------------------------------------------------


class taobao
{
	public $user      = 0;
	public $config    = array(
		'authcode' => '',  // 授权码
		'not_sale' => 0,   // 默认上下架
		'addorder' => 0,   // 采集评论时伪造订单
		'appkey  ' => '',  // 淘宝客Appkey
		'appsecret'=> '',  // 淘宝客AppSecre
		'list_appkey  ' => '',  // 淘宝客Appkey
		'list_appsecret'=> '',  // 淘宝客AppSecre
		'comment ' => '',  // 评论关键词过滤
		'unsale ' => 0
	);  
	public $code      = '';
	
	public $api_domain = 'http://tbapi.dm299.com';
	
	public function __construct($user_id=0)
	{
		$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('taobao') . ' WHERE user_id = \'' . $user_id . '\'';
		$config  = $GLOBALS['db']->getRow($sql);
		
		if( !$config ) {
			if( $user_id ==0 ) die("数据库存在错误，无法操作！");
			$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('taobao') . ' WHERE user_id = \'0\'';
			$config  = $GLOBALS['db']->getRow($sql);
			$config['user_id']=$user_id;
			unset($config['taobao_id']);
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('taobao'), $config);
		}

		$this->config = $config;
		$this->user_id = $user_id;
		$this->type	    = $this->config['programType'];
		if( $user_id>0 ) {
			$this->config['authcode']  = $GLOBALS['db']->getOne('SELECT authcode FROM ' . $GLOBALS['ecs']->table('taobao') . ' WHERE user_id = \'0\'');
		}
		include_once(ROOT_PATH . '/includes/cls_image.php');
		$this->image = new cls_image($_CFG['bgcolor']);
		$this->domain = $GLOBALS['ecs']->get_domain();

	}

	//  更新配置信息
	public function set_config($db_content)
	{
		return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('taobao'), $db_content, 'UPDATE', 'user_id=\'' . $this->user_id . '\'');
	}


	//  获得最新版本信息
	public function version()
	{
		$json = $this->file_get_contents_curl($this->api_domain."/tbapi.php?act=version&authcode=".$this->config['authcode']);
		return json_decode($json,1);
	}

	/**
	 * 搜索商品获得ID
	 *
	 * @access  public
	 * @return  array
	 */
	public function search_goods($param)
	{
		$taobao_id = implode(",",$this->get_all_goods_sn());
		$json = $this->file_get_contents_curl($this->api_domain."/tbapi.php?act=serach&authcode=".$this->config['authcode']."&appkey=".$this->config['appkey']."&appsecret=".$this->config['appsecret']."&".http_build_query($param),"POST","taobao_id=".$taobao_id);
		return json_decode($json,1);
	}

	/**
	 * 采集商品数据
	 *
	 * @access  public
	 * @param   integer     $id				淘宝商品ID
	 * @param   integer     $num		    商品主图片下载数量
	 * @param   integer     $goods_number   商品库存
	 * @param   integer     $cat_id			商品属性分类
	 * @param   integer     $pic_save		描述内容 图片是否下载到本地
	 * @param   integer     $price		    商品价格
	 * @param   integer     $cat_id			商品分类
	 * @return  array
	 */
	public function collect($id,$num=2,$goods_number=0,$cat_id=0,$pic_save=0,$price='N',$category_id=0,$brand_id=0)
	{
		$id		= $this->GetGoodsID($id);

		if (empty($id)) {
			$this->code = '淘宝商品URL不能为空';return false;
		}

		$json = $this->file_get_contents_curl($this->api_domain."/tbapi.php?id={$id}&act=shop&authcode=".$this->config['authcode']."&appkey=".$this->config['appkey']."&appsecret=".$this->config['appsecret']);

		$data = json_decode($json,1);

		// 错误提示
		if( $data['code']== 0 ) {
			$this->code =$data['data'];return false;
		}
		// 商品图片
		if($data['data']['picsPath']){
			$imgArr = array();
			foreach($data['data']['picsPath'] as $k=>$img){
				if($k>=$num) break;
				$imgArr[$k] = $this->getImg($img);
			}
		}

		$this->cat_id = $cat_id;
		$this->goods_props = $data['data']['props'];
		$this->skus = $data['data']['skus'];

		/* 商品属性加入到描述
		if( $goods_type==1 ) {
			$props = $data['data']['props'];
			if($props){
				$goods_props = '';
				foreach($props as $p){
					$goods_props .= "<p>{$p['name']}：{$p['value']}</p>";
				}
				$data['data']['desc'] = $goods_props.$data['data']['desc'];
			}
		}
		*/

		// 描述内容 图片下载到本地
		if( $pic_save==1 ) {
		  preg_match_all('/<img[^>]*src\s*=\s*([\'"]?)([^\'" >]*)\1/isu',$data['data']['desc'], $src);
		  $xt=$src[2];
		  foreach($xt as $k=>$v){
				$img = $this->file_get_contents_curl($v);
				$fileName = ROOT_PATH.'/images/taobao/';
				$arr = explode('.',$v);
				$ext = end($arr);
				$uniq = md5($v);//设置一个唯一id
				$name = $fileName.$uniq.'.'.$ext; //图像保存的名称和路径
				$root=$GLOBALS['ecs']->url();
				$data['data']['desc'] = str_replace($v,$root.'images/taobao/'.$uniq.'.'.$ext,$data['data']['desc']);
				file_put_contents($name,$img);
			}
		}
		// 设置库存
		$goods_number = $goods_number < 1 ? $data['data']['quantity'] : $goods_number;

		// 设置价格
		$taobao_price = explode('-',$data['data']['price']);
		$price = str_replace('N',$taobao_price[0],trim($price));
		$price  = eval("return ".$price."; ");

		$this->goods = array(
			'goods_name'			=> $data['data']['title'],
			'cat_id'			    => $category_id,                 // 商品分类 other_catids
			'brand_id'				=> $brand_id,
			'shop_price'			=> $price,
			'market_price'          => $price*2,                // 市场价
			'goods_img'             => $imgArr[0]['goods_img'],
			'goods_thumb'		    => $imgArr[0]['goods_thumb'],
			'original_img'          => $imgArr[0]['original_img'],
			'goods_number'			=> $goods_number,
			'goods_desc'            => $data['data']['desc'],
			'goods_type'			=> $cat_id
		);
		$this->imgArr = $imgArr;
		$this->taobao_id = $id;

		return true;
	}
	
	// 商品导入数据库
	public function add_goods($goods=null)
	{
		$goods  = $goods==null ? $this->goods : $goods;

		// 设置货号
		$max_id = $GLOBALS['db']->getOne('SELECT MAX(goods_id) + 1 FROM ' . $GLOBALS['ecs']->table('goods'));
		$goods_sn = generate_goods_sn($max_id);

		$dsc_goods = array(
			'goods_name'			=> '',
			'goods_name_style'		=> '+',
			'goods_sn'				=> $goods_sn,
			'cat_id'			    => 0,                 // 商品分类 other_catids
			'brand_id'				=> 0,
			'shop_price'			=> 0,
			'market_price'          => 0,                // 市场价
			'cost_price'            => 0,
			'is_promote'		    => 0,
			'promote_price'         => 0,
			'promote_start_date'    => 0,
			'promote_end_date'      => 0,
			'goods_weight'			=> 500,					 // 商品重量
			'goods_number'			=> 0,
			'warn_number'           => '5',					// 库存警告
			'integral'			    => 0,					// 积分购买金额
			'give_integral'         => 0,					// 赠送消费积分数 
			'is_best'				=> 0,
			'is_new'				=> 1,
			'is_hot'				=> 0,
			'is_on_sale'            => $this->config['not_sale'],				   // 是否上架
			'is_alone_sale'         => 1,
			'add_time'				=> gmtime(),
			'last_update'			=> gmtime(),

		);
		
		// 商家版本
		if( $this->user_id>0) {
			if($this->type=='xjd' ) {
				$dsc_goods['supplier_id'] = $this->user_id;
				$dsc_goods['supplier_status'] =1;
			}
		}


		if( $this->type=='dscmall' ) {
			$adminru = get_admin_ru_id();
			$dsc_goods['user_id'] = $adminru['ru_id'];
			$dsc_goods['review_status'] = 5; // 商品审核
			if (file_exists(MOBILE_DRP)) {
				$dsc_goods['is_distribution'] = 0;
				$dsc_goods['dis_commission'] = 0;
			}
		}

		$goods=array_merge($dsc_goods,$goods);
		$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('goods'), $goods);
		$goods['goods_id'] = $GLOBALS['db']->insert_id();
	
		if ($goods['goods_id']) 
		{
			// 设置商品图片
			foreach($this->imgArr as $v){
				$GLOBALS['db']->query("insert into ".$GLOBALS['ecs']->table('goods_gallery')." (goods_id,img_url,thumb_url,img_original) value ({$goods[goods_id]},'{$v[goods_img]}','{$v[goods_thumb]}','{$v[original_img]}')");
			}
			// 记录已采集的淘宝ID
			$GLOBALS['db']->query( 'INSERT INTO ' . $GLOBALS['ecs']->table('taobao_goods') . '(`goods_id`,`taobao_id`) VALUES (\'' . $goods['goods_id'] . '\',\''.$this->taobao_id.'\')');
			
			if( $this->type=='dscmall' ) {
				// 设置商品服务  正品保证  包退服务 闪速配送
				$GLOBALS['db']->query( 'INSERT INTO ' . $GLOBALS['ecs']->table('goods_extend') . '(`goods_id`, `is_reality`, `is_return`, `is_fast`) VALUES (\'' . $goods['goods_id'] . '\',0,0,0)');
				get_updel_goods_attr($goods_id);
			}

			// 商家版本
			if( $this->user_id>0) {
				if($this->type=='xjd' ) {
					$GLOBALS['db']->query( 'INSERT INTO ' . $GLOBALS['ecs']->table('supplier_goods_cat') . '(`goods_id`, cat_id, supplier_id) VALUES (\'' . $goods['goods_id'] . '\',0,\''.$this->user_id.'\')');
				}
			}
			// 设置商品属性和SKU
			$this->setGoodsAttr($goods['goods_id']);
		}

		return $goods;	
	}


	
	// 设置商品属性和SKU
	public function setGoodsAttr($goods_id)
	{
		if( $this->cat_id  ==0 ) return null;

		// 插入规格
		if( $this->goods_props ) {
			$sql = "select attr_id,attr_name from " .$GLOBALS['ecs']->table('attribute'). " where cat_id='".$this->cat_id."' and attr_input_type=0  and attr_type=0";
			$sql_attr= $GLOBALS['db']->getAll($sql);
			$attr = array();
			foreach($sql_attr as $val) {
				$attr[$val['attr_id']] = $val['attr_name'];
			}

			$no_attr= array('品牌','库存','货号');
			foreach($this->goods_props as $p){
				$p['name'] = trim($p['name']);
				$p['value'] = trim($p['value']);
				if( in_array($p['name'],$no_attr) ) continue;
				$attr_id = array_search($p['name'],$attr);
				if( $attr_id===false ) {
					$GLOBALS['db']->query("INSERT INTO " .$GLOBALS['ecs']->table('attribute'). " (`cat_id` ,`attr_name`,`attr_input_type` ,`attr_type` ) VALUES ('".$this->cat_id."', '".$p['name']."',0,0)");
					$attr_id = $GLOBALS['db']->insert_id();
				}
				$GLOBALS['db']->query("INSERT INTO " .$GLOBALS['ecs']->table('goods_attr'). " (attr_id, goods_id, attr_value, attr_price) VALUES ('".$attr_id."', '". $goods_id."', '".$p['value']."', '0')");
			}
		}

		// 插入SKU
		if( $this->skus ) {
			// 单选属性
			$sql = "select attr_id,attr_name from " .$GLOBALS['ecs']->table('attribute'). " where cat_id='".$this->cat_id."' and attr_input_type=0  and attr_type=1";
			$sql_attr= $GLOBALS['db']->getAll($sql);
			$attr = array();
			foreach($sql_attr as $val) {
				$attr[$val['attr_id']] = $val['attr_name'];
			}

			// 正常是没有数据的
			$sql = "select goods_attr_id,attr_id,attr_value from " .$GLOBALS['ecs']->table('goods_attr'). " where goods_id ='".$goods_id."' ";
			$properties = $GLOBALS['db']->getAll($sql);
			$goods_attr = array();
			foreach((array)$properties as $key=>$val) {
				if( empty($goods_attr[$val['attr_id']]) ) $goods_attr[$val['attr_id']] = array();
				$goods_attr[$val['attr_id']][$val['goods_attr_id']] = $val['attr_value'];
			}

	
			// product_sn 检测：货品货号是否在商品表和货品表中重复
			foreach($this->skus as $key=>$product) 
			{
				$add_goods_attr_id = array();
				foreach($product['props'] as $props_attr)
				{
					$props_attr['title'] = trim($props_attr['title']);
					$attr_id = array_search($props_attr['title'],$attr);

					# error 属性名称和 规格名称重复
					if( $attr_id===false ) {
						$GLOBALS['db']->query("INSERT INTO " .$GLOBALS['ecs']->table('attribute'). " (`cat_id` ,`attr_name`,`attr_input_type` ,`attr_type`  ) VALUES ('".$this->cat_id."', '".$props_attr['title']."',0,1)");
						$attr_id = $GLOBALS['db']->insert_id();
						$attr[$val['attr_id']] = $props_attr['title'];
					}
					# end

					$goods_attr_id = false;
					if( !empty($goods_attr[$attr_id]) ) {
						$goods_attr_id = array_search($props_attr['name'],$goods_attr[$attr_id]);
					}

					# error 属性价格
					if( $goods_attr_id === false ) {
						$GLOBALS['db']->query("INSERT INTO " .$GLOBALS['ecs']->table('goods_attr'). " (goods_id ,attr_id,attr_value ,`attr_price` ) VALUES ('".$goods_id."','".$attr_id."' ,'".$props_attr['name']."',0)");
						$goods_attr_id = $GLOBALS['db']->insert_id();
						if( empty($goods_attr[$attr_id]) ) $goods_attr[$attr_id] = array();
						$goods_attr[$attr_id][$goods_attr_id] = $props_attr['name'];
					}
					# end

					$add_goods_attr_id[]= $goods_attr_id;
				}

				$sort_goods_attr_id = sort_goods_attr_id_array($add_goods_attr_id);  // 大商创内置函数 - 小京东内置函数
				$goods_attr_str = '';
				if (!empty($sort_goods_attr_id['sort'])) {
					$goods_attr_str = implode('|', $sort_goods_attr_id['sort']);
				}

				// 插入货品
				$products_sql_arr = array('goods_id'=>$goods_id, 'goods_attr'=>$goods_attr_str, 'product_sn'=>$goods_id."_".$product['product_sn'], 'product_number'=>$product['product_number']);
				if( $this->type=='dscmall' ) {
					$products_sql_arr['product_price'] = $product['price'];
				}	
				$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('products'), $products_sql_arr);
			}
		}
		return ;
	}

	// 获得商品ID
	public function GetGoodsID($Url)
	{
		$b = (explode("&", $Url));
		foreach ($b as $v) {
			if (stristr($v, "id=")) {
				$str = $v . ">";
				preg_match("/id=(.*)>/", $str, $c);
				$reslt = $c[1];
				$u = (explode("#", $reslt));
				return $u[0];
				break;
			}
		}
		return $Url;
	}

	// 图片下载
	public function getImg($url) 
	{
		$name = $this->download_img($url,ROOT_PATH.'images/taobao/');
		$name = ROOT_PATH.'images/taobao/'.$name;
		$thumb_url = $this->image->make_thumb($name, $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);
		$img_url = $this->image->make_thumb($name , $GLOBALS['_CFG']['image_width'],  $GLOBALS['_CFG']['image_height']);
		$img_original = $this->image->make_thumb($name);
		$img_original = reformat_image_name('gallery', $gid, $img_original, 'source');
		$img_url = reformat_image_name('gallery', $gid, $img_url, 'goods');
		$thumb_url = reformat_image_name('gallery_thumb', $gid, $thumb_url, 'thumb');
		$img = array('original_img'=>$img_original,'goods_img'=>$img_url,'goods_thumb'=>$thumb_url);
		if( $this->type=='dscmall') {get_oss_add_file($img);}// oss
		return $img;
	}

	// 运程连接
	public function file_get_contents_curl($url,$method='GET',$params=''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); // 从证书中检查SSL加密算法是否存在
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10); 
		curl_setopt($ch, CURLOPT_REFERER,$this->domain); 
		if( $method=='POST' ) 
		{
			curl_setopt($ch, CURLOPT_POST,true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
		}

		$dxycontent = curl_exec($ch); 
		return $dxycontent;
	}


	// 开始输出调用
	public function flush_echo($data) 
	{
		ob_start();
		ob_implicit_flush(1);
		echo $data;
		ob_end_flush();
	}

	// 实时输出调用
	public function flush_echos($data,$ext=0) 
	{
		echo('<script type="text/javascript">showmessage(\''.addslashes($data).'\','.$ext.');</script>'."\r\n");
		ob_flush();
		flush();
	}
	
	//  获得所有已经采集过的淘宝ID
	public function get_all_goods_sn()
	{
		$count = $GLOBALS['db']->getAll('SELECT taobao_id FROM ' .$GLOBALS['ecs']->table('taobao_goods'). " where taobao_id!=''");//获取所有货号
		$all_goods_sn =array();
		foreach((array)$count as $key=>$value)
		{
			$all_goods_sn[]=$value['taobao_id'];
		}
		if (!$all_goods_sn)
			$all_goods_sn[0]=0;
		
		return $all_goods_sn;
	}

	//  清理重复项和删除项
	public function chk_collect_goods()
	{
		$sql = "select id from " .$GLOBALS['ecs']->table('taobao_goods'). 
				" where taobao_id in (select taobao_id from " .$GLOBALS['ecs']->table('taobao_goods'). " group by taobao_id having count(taobao_id) > 1) ".
				" and goods_id not in (select min(goods_id) from " .$GLOBALS['ecs']->table('taobao_goods'). " group by taobao_id having count(taobao_id )>1) ";  
		$goods = $GLOBALS['db']->getAll($sql);
		
		if( $goods ) {
			foreach($goods as $key=>$val) {
				$GLOBALS['db']->query( "delete from " .$GLOBALS['ecs']->table('taobao_goods')." where id='".$val['id']."'" );
			}
		}
		$str ="找到 ".count($goods)." 个重复项，并且已清理<br/>";

		$sql = "SELECT t.id FROM  ".$GLOBALS['ecs']->table('taobao_goods')." as t  WHERE ".
			   "(SELECT COUNT(1) AS num FROM ".$GLOBALS['ecs']->table('goods')." as g  WHERE t.goods_id=g.goods_id) = 0;  ";  
		$goods = $GLOBALS['db']->getAll($sql);

		if( $goods ) {
			foreach($goods as $key=>$val) {
				$GLOBALS['db']->query("delete from " .$GLOBALS['ecs']->table('taobao_goods')." where id='".$val['id']."'" );
			}
		}
		$str .="找到 ".count($goods)." 个删除项，并且已清理<br/>";

		$str .=$this->del_table_comment();

		return $str;
	}

	//  上下架
	public function check_unsale()
	{
		$stime=time()+microtime();
		$flag = 0;
		$goods = $GLOBALS['db']->getAll("SELECT tb.*,g.goods_name FROM  ".$GLOBALS['ecs']->table('taobao_goods')." as tb ".
										"LEFT JOIN ".$GLOBALS['ecs']->table('goods')." as g on g.goods_id=tb.goods_id");
		foreach($goods as $key=>$val) 
		{
			$json = $this->file_get_contents_curl($this->api_domain."/tbapi.php?id=".$val['taobao_id']."&act=check_unsale&authcode=".$this->config['authcode']."&list_appkey=".$this->config['list_appkey']."&list_appsecret=".$this->config['list_appsecret']);
			$data = json_decode($json,1);

			// 错误提示
			if( $data['code']== 0 ) {
				$this->flush_echos( '<font color="red">发生错误</font>');
				$this->flush_echos( $data['data']);
				break;
			}
			if ( $data['data']=='1' )
			{
				$this->flush_echos($this->api_domain."/tbapi.php?id=".$val['taobao_id']."&act=check_unsale&authcode=".$this->config['authcode']."&list_appkey=".$this->config['list_appkey']."&list_appsecret=".$this->config['list_appsecret']);		
				if( $this->config['unsale']==1 ) {
					$GLOBALS['db']->query('UPDATE ' .$GLOBALS['ecs']->table('goods') .' set is_delete = 1 where goods_id='.$val['goods_id']);
				}
				$this->flush_echos('商品【<a target="_blank" href="http://item.taobao.com/item.htm?id=' .$val['taobao_id'].'">'.$val['goods_name'].'</a>】<font style="color:#0000FF"> 已下架</font>');
				$flag++;
			}
			else
			{
				$this->flush_echos('商品【'.$val['goods_name'].'】销售正常');		
			}
		}
		$etime=time()+microtime();
		$pass_time=sprintf("%.2f", $etime-$stime);//消耗时间
		$this->flush_echos( '<font color="red"><strong>['. $flag. ']</strong>个商品下架！</font>(用时：'.$pass_time.'秒)');
		$this->flush_echos( '进入<a href="goods.php?act=trash">进入商品回收站</a> <a href="collect_goods.php?act=tool">继续下架检测</a>',1);
	}

	// 删除评论重复项
	public function del_table_comment(){

		$sql = "select id from " .$GLOBALS['ecs']->table('taobao_goods_comment'). 
				" where goods_id in (select goods_id from " .$GLOBALS['ecs']->table('taobao_goods_comment'). " group by goods_id having count(goods_id) > 1) ".
				" and id not in (select max(id) from " .$GLOBALS['ecs']->table('taobao_goods_comment'). " group by goods_id having count(goods_id )>1) ";  
		$comment = $GLOBALS['db']->getAll($sql);
		
		if( $comment ) {
			foreach($comment as $key=>$val) {
				$GLOBALS['db']->query( "delete from " .$GLOBALS['ecs']->table('taobao_goods_comment')." where id='".$val['id']."'" );
			}
		}
		$str ="找到 ".count($comment)." 个评论重复项，并且已清理<br/>";

		$sql = "SELECT t.id FROM  ".$GLOBALS['ecs']->table('taobao_goods_comment')." as t  WHERE ".
			   "(SELECT COUNT(1) AS num FROM ".$GLOBALS['ecs']->table('goods')." as g  WHERE t.goods_id=g.goods_id) = 0;  ";  
		$goods = $GLOBALS['db']->getAll($sql);

		if( $goods ) {
			foreach($goods as $key=>$val) {
				$GLOBALS['db']->query("delete from " .$GLOBALS['ecs']->table('taobao_goods_comment')." where id='".$val['id']."'" );
			}
		}
		$str .="找到 ".count($goods)." 个商品删除项，评论同步表已清理<br/>";

		return $str;
	}

	// 同步所有评论
	public function synchro_comment($stime)
	{
		$this->del_table_comment();

		$where = '';
		// 商家版本
		if( $this->user_id>0) {
			if($this->type=='xjd' ) {
				$where = " and g.supplier_id='".$this->user_id."' and g.supplier_status=1 ";
			}
		}


		$sql = "SELECT t.* FROM  ".$GLOBALS['ecs']->table('taobao_goods_comment')." as t  ".
			   " left join ".$GLOBALS['ecs']->table('goods')." as g on t.goods_id=g.goods_id where g.is_on_sale=1 and g.is_delete=0 ".$where;
		$comment = $GLOBALS['db']->getAll($sql);

		if( $comment ) {
			foreach($comment as $key=>$val) {
				if( empty($val['taobao_id']) or empty($val['goods_id']) ) continue;
				if( $val['update_time']<gmtime()+3600 ) {
					$this->flush_echos('商品Id【<a href="../goods.php?id='.$val['goods_id'].'" target="_blank">'.$val['goods_id'].'</a>】已跳过采集，1小时内已采集过此商品');//输出信息		  
					continue;
				}
				$data  = $this->get_comment($val['taobao_id'],$val['goods_id'],0);
				// 错误提示
				if( $data['code']== 0 ) {
					$this->flush_echos('采集出错：'.$data['data']);//输出信息		  
				}
				else {
					$comment_list = $data['data'];
					foreach($comment_list as $k=>$c){
						$this->insert_comment($c,$val['taobao_id'],$val['goods_id']);
					}
					$this->flush_echos('商品Id【<a href="../goods.php?id='.$val['goods_id'].'" target="_blank">'.$val['goods_id'].'</a>】成功入库 '.count($comment_list)." 条评论！");//输出信息		  
				}
			}
		}
		$etime=time()+microtime();
		$pass_time=sprintf("%.2f", $etime-$stime);//消耗时间
		$this->flush_echos( '同步<font color="red"><strong>['. count($comment). ']</strong>条</font>评论商品完成！(用时：'.$pass_time.'秒)');
		$this->flush_echos( '<a href="collect_goods.php?act=comment">继续采集</a>',1);
	}

	// 评论采集
	public function get_comment($taobao_id,$goods_id,$cnum=0)
	{
		$taobao_id = $this->GetGoodsID($taobao_id);
		$goods_comment = $GLOBALS['db']->getRow("SELECT * FROM " .$GLOBALS['ecs']->table('taobao_goods_comment')." WHERE taobao_id = '".$taobao_id."' and goods_id='".$goods_id."'");
		if( $goods_comment ) {
			if( $cnum<1  and $goods_comment['update_time']<gmtime()+24*3600 ) {
				return array('code'=>2,'data'=>array());
			}
		}
		else {
			$GLOBALS['db']->query( "delete from ".$GLOBALS['ecs']->table('taobao_goods_comment')." WHERE goods_id='".$goods_id."'");
			$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('taobao_goods_comment'), array('goods_id'=>$goods_id,'taobao_id'=>$taobao_id,'update_time'=>gmtime()));
		}
		$comment_id = $GLOBALS['db']->getOne("SELECT GROUP_CONCAT(comment_id separator ',') FROM " .$GLOBALS['ecs']->table('taobao_comment') ." where taobao_id = '".$taobao_id."' and goods_id='".$goods_id."'");
		$url = $this->api_domain."/tbapi.php?act=get_comment&authcode=".$this->config['authcode']."&appkey=".$this->config['appkey']."&appsecret=".$this->config['appsecret']."&taobao_id=".$taobao_id."&cnum=".$cnum;
		$json = $this->file_get_contents_curl($url,"POST","comment_id=".$comment_id."&comment=".$this->config['comment']);
		return json_decode($json,1);
	}


	// 插入评论
	public function insert_comment($c,$taobao_id,$goods_id=0)
	{
		$order_id = 0;
		if( $this->config['addorder'] ) {
			$order_id =  $this->createOrder($goods_id,local_strtotime($c['rateDate']),$c['nick']);
		}
		$comment = array(
			'id_value'		=> $goods_id,
			'content'		=> $c['feedback'],
			'comment_rank'	=> 5,
			'add_time'		=> local_strtotime($c['rateDate']),
			'user_name'		=> $c['nick'],
			'status'		=> 1
		);
		if( $this->type=='dscmall' ) {
			$comment['order_id'] = $order_id;
		}
		$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('taobao_comment'), array('goods_id'=>$goods_id,'taobao_id'=>$taobao_id,'comment_id'=>$c['id']));
		$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('comment'), $comment);

		if( $this->config['comment_img'] and  $c['pics']) 
		{
			$comment_id = $GLOBALS['db']->insert_id();
			
			// 评论插入图片 （大商创）
			if( $this->type=='dscmall') 
			{
				$comment_img = array(
					'user_id' =>0,
					'order_id' =>$order_id,
					'rec_id' =>0,
					'goods_id' =>$goods_id,
					'comment_id' =>$comment_id,
					'comment_img' =>0,
					'img_thumb' =>0,
				);

				foreach($c['pics'] as $key=>$url) 
				{
					$name = $this->download_img($url,ROOT_PATH.'images/taobao_cmt/original/');
					$img_thumb   = $this->image->make_thumb(ROOT_PATH.'images/taobao_cmt/original/'.$name, $GLOBALS['_CFG']['single_thumb_width'], $GLOBALS['_CFG']['single_thumb_height'], ROOT_PATH . '/images/taobao_cmt/thumb/');
					$comment_img['comment_img'] ="images/taobao_cmt/original/".$name;
					$comment_img['img_thumb'] =ltrim($img_thumb,"/");
					get_oss_add_file(array($comment_img['comment_img'],$comment_img['img_thumb']));
					$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('comment_img'), $comment_img);
				}
			}
			// 小京东晒单
			if( $this->type=='xjd') 
			{
				$shaidan = array('user_id' =>0,'goods_id' =>$goods_id,'rec_id' =>$order_id,'title' =>'','message' =>$c['feedback'],'add_time' =>local_strtotime($c['rateDate']),'status' =>1,'hide_username' =>0);
				$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('shaidan'), $shaidan);
				
				$comment_img = array('shaidan_id'=>$GLOBALS['db']->insert_id());
				foreach($c['pics'] as $key=>$url) 
				{
					$name = $this->download_img($url,ROOT_PATH.'images/taobao_cmt/original/');
					$img_thumb   = $this->image->make_thumb(ROOT_PATH.'images/taobao_cmt/original/'.$name, $GLOBALS['_CFG']['single_thumb_width'], $GLOBALS['_CFG']['single_thumb_height'], ROOT_PATH . '/images/taobao_cmt/thumb/');
					$comment_img['image'] ="images/taobao_cmt/original/".$name;
					$comment_img['thumb'] =ltrim($img_thumb,"/");
					$GLOBALS['db']->autoExecute( $GLOBALS['ecs']->table('shaidan_img'), $comment_img);
				}
			}

		}


		return true;
	}

	// 伪造订单
	public function createOrder($gid,$t,$nick){
		$order = array();
		$order['add_time']     = $t-7*86400;//购买时间直接倒数7天
		$order['order_status'] = OS_CONFIRMED;
		$order['confirm_time'] = $t-3*86400;
		$order['pay_status']   = PS_PAYED;
		$order['pay_time']     = $t-7*86400;
		$order['shipping_status']   =2;
		$order['order_amount'] = 0;
		$order['order_sn'] = $this->get_order_sn(); //获取新订单号
		$order['tb_nick'] = $nick;

		for($i=0; $i<1000; $i++) {
			$order_id = $GLOBALS['db']->getOne("select order_sn from ".$GLOBALS['ecs']->table('order_info')." where order_sn='".$order['order_sn']."'");
			if( $order_id ) {
				$order['order_sn'] = $this->get_order_sn(); //获取新订单号
			}
			else {
				break;
			}
		} 

		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');
		$new_order_id = $GLOBALS['db']->insert_id();
		$goods = $GLOBALS['db']->getRow("select * from ".$GLOBALS['ecs']->table('goods')." where goods_id=$gid");
		$sql = "INSERT INTO " . $GLOBALS['ecs']->table('order_goods') . "( " .
			"order_id, goods_id, goods_name, goods_sn, goods_number, market_price,
			goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id) value ".
			"({$new_order_id},$gid,'{$goods['goods_name']}','{$goods['goods_sn']}',1,0,0,'',0,'',0,0,0)";
		$GLOBALS['db']->query($sql);
		return $GLOBALS['db']->insert_id();
	}
	
	// 生成订单号
	public function get_order_sn()
	{
		$time = explode(' ', microtime());
		$time = $time[1] . ($time[0] * 1000);
		$time = explode('.', $time);
		$time = (isset($time[1]) ? $time[1] : 0);
		$time = date('YmdHis') + $time;
		//mt_srand((double) microtime() * 1000000);
		return $time . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	}


	//  下载图片
	public function download_img($url,$fileName){
		$qz = substr($url, 0, 2);
		if(strtolower($qz) == '//') $url = 'https:'.$url;
		$arr = explode('.',$url);
		$ext = end($arr);
		$uniq = md5($url);//设置一个唯一id
		$name = $fileName.$uniq.'.'.$ext; //图像保存的名称和路径
		$img = $this->file_get_contents_curl($url);
		file_put_contents($name,$img);
		return $uniq.'.'.$ext;
	}

/*
	//  伪造会员
	public function register($username='dm299'){
		$ran = range(3,10);
		$username_start = mb_substr($username, 0, 1, 'utf-8');
		$username_end = mb_substr($username, -1, 1, 'utf-8');
		$username_new = $username_start . $ran.'taobao' . $username_end;
		$password = "wwwdm299com";
		$email = $ran."@163.com";
		if (register($username, $password, $email, array()) !== false) 
		{

			/// headimg
			$sql = 'UPDATE ' . $GLOBALS['ecs']->table('users') . " SET user_rank = " . $user_rank . ", user_picture = " . $user_picture."  WHERE user_name = '" . $username."'";
			$GLOBALS['db']->query($sql);
		}
	}
*/

	//  商品分类品牌直接输出样式
	public function showhtml()
	{
		$cat=$this->get_category_list(0);
		$brand_list = get_brand_list();
		$brand = '<li><a href="javascript:void(0);" data-value="">请选择品牌</a></li>';
		foreach ($brand_list AS $key=>$var)
		{
			$brand .= '<li><a href="javascript:void(0);" data-value="' . $key . '">"'.$var.'"</a></li>';
		}	
		$GLOBALS['smarty']->assign('cat_list',$cat['content'] );
		$GLOBALS['smarty']->assign('brand',$brand );
	}

	//  商品分类 三级
	public function get_category_list($cat_id = 0)
	{
		$level = 1;$cat_nav=$navigation = '';
		if( $cat_id>0 ) {
			$cid = $cat_id;$pid =0;
			// 最多执行4次，防止直接数据库操作导致的数据异常，进入死循环
			for($i=0; $i<4; $i++) {
				$cat = $GLOBALS['db']->getRow("SELECT cat_id, cat_name,parent_id FROM " .$GLOBALS['ecs']->table('category')." WHERE cat_id = '".$cid."'");

				if( $pid ==0 ) $pid = $cat['parent_id'];
				if( $navigation !='' ) {$navigation = ' &gt '.$navigation;$cat_nav = ' > '.$cat_nav ;}
				$navigation ='<a href="javascript:;" class="categoryOne" data-cid="'.$cat['cat_id'].'" data-cname="'.$cat['cat_name'].'">'.$cat['cat_name'].'</a>'.$navigation;
				$cat_nav =$cat['cat_name'].$cat_nav;
				$cid = $cat['parent_id'];
				$level++;
				if( $cat['parent_id']==0 ) break;
			}
		}
		if( $navigation=='' ) {
			$navigation ='<span>请选择分类</span>';
			$cat_nav ='请选择分类';
		}

		$sql = "SELECT cat_id, cat_name FROM " . $GLOBALS['ecs']->table('category') . " WHERE parent_id = '".$cat_id."'";
		if( $level>=4 ) {
			$sql = "SELECT cat_id, cat_name FROM " . $GLOBALS['ecs']->table('category') . " WHERE parent_id = '".$pid."'";
		}
		$category_list = $GLOBALS['db']->getAll($sql);
		$category_html = '';
		$levelhtml =  $level==1 ? 'Ⅰ':($level==2 ? 'Ⅱ' : 'Ⅲ');
		foreach ($category_list as $key => $val) {
			$is_selected = '';
			if ($cat_id == $val['cat_id']) {
				$is_selected = ' class="blue"';
			}
			$category_html .='<li data-cid="'.$val['cat_id'].'" data-cname="'.$val['cat_name'].'"'.$is_selected.'><em>'.$levelhtml.'</em>'.$val['cat_name'].'</li>';
		}
		$content = '<div class="select-top"><a href="javascript:;" class="categoryTop" data-cid="0" data-cname="">重选</a> &gt '.$navigation.'</div><div class="select-list ps-container"><ul>'.$category_html.'</ul></div>';
		return array('cat_nav'=>$cat_nav,'content'=>$content);
	}

	/**
	 * 取得通用属性和某分类的属性，以及某商品的属性值
	 * @return  array   分类列表
	 */
	public function get_goods_type_list()
	{
		if( $this->type=='dscmall') {
			$row = $GLOBALS['db']->GetAll("SELECT cat_id,cat_name FROM " .$GLOBALS['ecs']->table('goods_type'). " WHERE enabled=1 and user_id='".$this->user_id."'");
		}
		else {
			$row = $GLOBALS['db']->GetAll("SELECT cat_id,cat_name FROM " .$GLOBALS['ecs']->table('goods_type'). " WHERE enabled=1");
		}
		$goods_type_list = '<li><a href="javascript:void(0);" data-value="0">不采集SKU和规格</a></li>';
		foreach ($row AS $var)
		{
			if ( $var['cat_name'] == "采集属性" ) {
				$GLOBALS['smarty']->assign('goods_type_list_selected',$var['cat_id']);
			}
			$goods_type_list .= '<li><a href="javascript:void(0);" data-value="' . $var['cat_id'] . '">'.$var['cat_name'].'</a></li>';
		}	
		$GLOBALS['smarty']->assign('goods_type_list',$goods_type_list);
	}

}
?>
