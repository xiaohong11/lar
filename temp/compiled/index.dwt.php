<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<?php echo $this->fetch('library/js_languages_new.lbi'); ?>
</head>

<body>
	<?php echo $this->fetch('library/page_header_common.lbi'); ?>
    <div class="content" ectype="lazyDscWarp">
    	<div class="banner home-banner">
        	<div class="bd">
				<?php echo $this->fetch('library/index_ad.lbi'); ?>
            </div>
            <div class="hd">
            	<ul></ul>
            </div>
            <div class="vip-outcon">
            	<?php 
$k = array (
  'name' => 'index_user_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
            </div>
        </div>
        <div class="channel-content" ectype="channel">
        <?php 
$k = array (
  'name' => 'index_seckill_goods',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
		<?php 
$k = array (
  'name' => 'get_adv_child',
  'ad_arr' => $this->_var['rec_cat'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
		<?php echo $this->fetch('library/index_brand_ad.lbi'); ?>
        </div>
        <div class="floor-content" ectype="goods_cat_level">
			
<?php $this->assign('cat_goods',$this->_var['cat_goods_6']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_6']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>
<?php $this->assign('cat_goods',$this->_var['cat_goods_8']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_8']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>
<?php $this->assign('cat_goods',$this->_var['cat_goods_12']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_12']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>
<?php $this->assign('cat_goods',$this->_var['cat_goods_858']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_858']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>

		</div>
        <div class="floor-loading" ectype="floor-loading"><div class="floor-loading-warp"><img src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/images/load/loading.gif"></div></div>
        <div class="other-content">
            <?php 
$k = array (
  'name' => 'get_adv_child',
  'ad_arr' => $this->_var['expert_field'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
            <?php 
$k = array (
  'name' => 'get_adv_child',
  'ad_arr' => $this->_var['recommend_merchants'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
            <?php echo $this->fetch('library/guess_you_like.lbi'); ?>
        </div>
        
     	
        <div class="lift lift-mode-<?php echo empty($this->_var['floor_nav_type']) ? 'one' : $this->_var['floor_nav_type']; ?> lift-hide" ectype="lift" data-type="<?php echo empty($this->_var['floor_nav_type']) ? 'one' : $this->_var['floor_nav_type']; ?>" style="z-index:100001">
            <div class="lift-list" ectype="liftList">
                <div class="lift-item lift-h-seckill lift-item-first" ectype="liftItem" data-target="#h-seckill"><span>秒杀活动</span><i class="lift-arrow"></i></div>
                <div class="lift-item lift-h-need lift-item-current" ectype="liftItem" data-target="#h-need"><span>推荐商品</span><i class="lift-arrow"></i></div>
                <div class="lift-item" ectype="liftItem" data-target="#h-brand"><span>品牌推荐</span><i class="lift-arrow"></i></div>
                <?php $_from = $this->_var['floor_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'data_0_21981400_1572696504');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['data_0_21981400_1572696504']):
?>
                <div class="lift-item lift-floor-item" ectype="liftItem"><span><?php echo $this->_var['data_0_21981400_1572696504']['name']; ?></span><i class="lift-arrow"></i></div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <div class="lift-item lift-master" ectype="liftItem" data-target="#master"><span>达人专区</span><i class="lift-arrow"></i></div>
                <div class="lift-item lift-storeRec" ectype="liftItem" data-target="#storeRec"><span>店铺推荐</span><i class="lift-arrow"></i></div>
                <div class="lift-item" ectype="liftItem" data-target="#guessYouLike"><span>还没逛够</span><i class="lift-arrow"></i></div>
                <div class="lift-item lift-item-top" ectype="liftItem"><?php if ($this->_var['floor_nav_type'] == "one"): ?><i class="iconfont icon-returntop"></i><?php else: ?>TOP<i class="iconfont icon-top-alt"></i><?php endif; ?></div>
            </div>
        </div>
        
        <div class="attached-search-container" ectype="suspColumn">
            <div class="w w1200">
                <div class="categorys site-mast">
                    <div class="categorys-type"><a href="<?php echo $this->_var['url_categoryall']; ?>" target="_blank"><?php echo $this->_var['lang']['all_goods_cat']; ?></a></div>
                    <div class="categorys-tab-content">
                        <?php 
$k = array (
  'name' => 'category_tree_nav',
  'cat_model' => $this->_var['nav_cat_model'],
  'cat_num' => $this->_var['nav_cat_num'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
                    </div>
                </div>
                <div class="mall-search">
                   <div class="dsc-search">
                        <div class="form">
                            <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm(this)" class="search-form">
                                <input autocomplete="off" name="keywords" type="text" id="keyword2" value="<?php if ($this->_var['search_keywords']): ?><?php echo $this->_var['search_keywords']; ?><?php else: ?><?php 
$k = array (
  'name' => 'rand_keyword',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?><?php endif; ?>" class="search-text"/>
                                <input type="hidden" name="store_search_cmt" value="<?php echo empty($this->_var['search_type']) ? '0' : $this->_var['search_type']; ?>">
                                <button type="submit" class="button button-goods" onclick="checkstore_search_cmt(0)" >搜商品</button>
                                <button type="submit" class="button button-store" onclick="checkstore_search_cmt(1)" >搜店铺</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="suspend-login">
                    <?php 
$k = array (
  'name' => 'index_suspend_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
                </div>
                <div class="shopCart" id="ECS_CARTINFO">
                    <?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
                </div>
            </div>
        </div>
    </div>

    <?php 
$k = array (
  'name' => 'user_menu_position',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
    
    <?php echo $this->fetch('library/page_footer.lbi'); ?>
    <?php if ($this->_var['cfg_bonus_adv'] == 1): ?>
        <?php 
$k = array (
  'name' => 'get_adv_child',
  'ad_arr' => $this->_var['bonushome'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
    <?php endif; ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'jquery.SuperSlide.2.1.1.js,jquery.yomi.js,cart_common.js,cart_quick_links.js')); ?>
    <script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/dsc-common.js"></script>
    <script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/asyLoadfloor.js"></script>
    <script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/jquery.purebox.js"></script>
    <script type="text/javascript">
	/*首页轮播*/
	var length = $(".banner .bd").find("li").length;
	if(length>1){
		$(".banner").slide({titCell:".hd ul",mainCell:".bd ul",effect:"fold",interTime:3500,delayTime:500,autoPlay:true,autoPage:true,trigger:"click",endFun:function(i,c,s){
			$(window).resize(function(){
				var width = $(window).width();
				s.find(".bd li").css("width",width);
			});
		}});
	}else{
		$(".banner .hd").hide();
	}
	$(".vip-item").slide({titCell:".tit a",mainCell:".con"});
	$(".seckill-channel").slide({mainCell:".box-bd ul",effect:"leftLoop",autoPlay:true,autoPage:true,interTime:5000,delayTime:500,vis:5,scroll:1,trigger:"click"});
	
	function load_js_content(key){
		var Floor = $("#floor_" + key);
		Floor.slide({titCell:".hd-tags li",mainCell:".floor-tabs-content",titOnClassName:"current"});
		Floor.find(".floor-left-slide").slide({titCell:".hd ul",mainCell:".bd ul",effect:"left",interTime:3500,delayTime:500,autoPlay:true,autoPage:true});
	}
	$("*[ectype='time']").each(function(){
		$(this).yomi();
	});
	
	//页面刷新自动返回顶部
	$("body,html").animate({scrollTop:0},50);
	
	$(function(){
		//判断首页那些广告位是否存在，处理左侧悬浮楼层栏
		var index_ad_cat = $("input[name='index_ad_cat']").val();
		
		if(index_ad_cat == 0){
			$(".lift-h-need").hide();
		}else{
			$(".lift-h-need").show();
		}
		
		//秒杀活动
		var seckill_goods = $("input[name='seckill_goods']").val();
		if(seckill_goods == 0){
			$(".lift-h-seckill").hide();
		}else{
			$(".lift-h-seckill").show();
		}
	});
	
	//楼层异步加载封装函数调用
	$.homefloorLoad();
	
	$(window).scroll(function(){
		var scrollTop = $(document).scrollTop();
		var navTop = $("*[ectype='channel']").offset().top;  //by yanxin
			
		if(scrollTop>navTop){
			$("*[ectype='suspColumn']").addClass("show");
		}else{
			$("*[ectype='suspColumn']").removeClass("show");
		}
	});
	
	//去掉悬浮框 我的购物车
	$(".attached-search-container .shopCart-con a span").text("");
    </script>
</body>
</html>
