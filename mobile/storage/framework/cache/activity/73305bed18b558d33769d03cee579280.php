<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="description" content="<?php echo $description; ?>"/>
    <meta name="keywords" content="<?php echo $keywords; ?>"/>
    <title><?php echo $page_title; ?></title>
    <?php echo global_assets('css');?>
    <script type="text/javascript">var ROOT_URL = '/mobile/';</script>
    <?php echo global_assets('js');?>
    <?php if($is_wechat) { ?>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script type="text/javascript">
        // 分享内容
        var shareContent = {
            title: '<?php echo ($share_data['title']); ?>',
            desc: '<?php echo ($share_data['desc']); ?>',
            link: '<?php echo ($share_data['link']); ?>',
            imgUrl: '<?php echo ($share_data['img']); ?>',
            success: function (res) {
                // 用户确认分享后执行的回调函数
                // res {"checkResult":{"onMenuShareTimeline":true},"errMsg":"onMenuShareTimeline:ok"}
                console.log(JSON.stringify(res));
                var msg = res.errMsg;
                var jsApiname = msg.replace(':ok','');
                shareCount(jsApiname,'<?php echo ($share_data['link']); ?>');
            }
        };

        // 分享统计
        function shareCount(jsApiname = '', link = ''){
            $.post('<?php echo url("wechat/jssdk/count");?>', {jsApiname: jsApiname, link:link}, function (res) {
                if(res.status == 200){
                    //
                }
            }, 'json');
        }

        $(function(){
            var url = window.location.href;
            var jsConfig = {
                debug: false,
                jsApiList: [
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'onMenuShareQZone'
                ]
            };
            $.post('<?php echo url("wechat/jssdk/index");?>', {url: url}, function (res) {
                if(res.status == 200){
                    jsConfig.appId = res.data.appId;
                    jsConfig.timestamp = res.data.timestamp;
                    jsConfig.nonceStr = res.data.nonceStr;
                    jsConfig.signature = res.data.signature;
                    // 配置注入
                    wx.config(jsConfig);
                    // 事件注入
                    wx.ready(function () {
                        wx.onMenuShareTimeline(shareContent);
                        wx.onMenuShareAppMessage(shareContent);
                        wx.onMenuShareQQ(shareContent);
                        wx.onMenuShareWeibo(shareContent);
                        wx.onMenuShareQZone(shareContent);
                    });
                }
            }, 'json');
        })
    </script>
    <?php } ?>
</head>
<body>
<p style="text-align:right; display:none;"><?php echo config('shop.stats_code');?></p>
<div id="loading"><img src="<?php echo elixir('img/loading.gif');?>" /></div>

<div class="con">
	<div class="act-header-box"><img src="<?php echo ($info['activity_thumb']); ?>"></div>
	<section class="m-top08 goods-evaluation">
		<a href="javascript:;">
			<div class="dis-box padding-all b-color-f  g-evaluation-title">
				<div class="box-flex">
					<h3 class="my-u-title-size">活动规则</h3> </div>
			</div>
		</a>

		<div class="padding-all-1 m-top1px b-color-f g-evaluation-con">
			<div class="of-hidden evaluation-list">
				<p class="act-cont">活动时间：<?php echo ($info['start_time']); ?> - <?php echo ($info['end_time']); ?></p>
				<p class="act-cont">金额上限：<?php echo ($info['max_amount']); ?> </p>
				<p class="act-cont">金额下限：<?php echo ($info['min_amount']); ?></p>
				<p class="act-cont">享受优惠的会员等级：<?php $n=1;if(is_array($info['user_rank'])) foreach($info['user_rank'] as $rank) { echo $rank; ?>&nbsp;<?php $n++;}unset($n); ?></p>
				<p class="act-cont">
					优惠范围：<?php echo ($info['act_range']); ?> <?php if($info['act_range_ext'] && $info['act_range_type'] != 3) { ?> ( <?php $n=1;if(is_array($info['act_range_ext'])) foreach($info['act_range_ext'] as $range_ext) { ?> <?php echo ($range_ext['name']); ?>&nbsp; <?php $n++;}unset($n); ?> ) <?php } ?>
				</p>
				<p class="act-cont">优惠方式：<?php echo ($info['act_type']); ?></p>
			</div>
		</div>
	</section>
	<?php if($info['gift']) { ?>
	<section class="m-top08 goods-evaluation">
		<a href="javascript:;">
			<div class="dis-box padding-all b-color-f  g-evaluation-title">
				<div class="box-flex">
					<h3 class="my-u-title-size">赠品（特惠品）</h3> </div>
			</div>
		</a>

		<section class="product-list j-product-list product-list-medium" data="1">
			<ul>
				<?php $n=1;if(is_array($info['gift'])) foreach($info['gift'] as $goods) { ?>
				<li>
					<div class="product-div">
						<a class="product-div-link" href="<?php echo ($goods['url']); ?>"></a>
						<img class="product-list-img" src="<?php echo ($goods['thumb']); ?>">
						<div class="product-text index-product-text">
							<h4><?php echo ($goods['name']); ?></h4>
							<p class="dis-box p-t-remark"><span class="box-flex">库存:<?php echo ($goods['goods_number']); ?></span><span class="box-flex">销量:<?php echo ($goods['sales_volume']); ?></span></p>
							<p><span class="p-price t-first ">
                        <?php echo ($goods['price']); ?>
                    </span></p>
						</div>
					</div>
				</li>
				<?php $n++;}unset($n); ?>
			</ul>
		</section>
	</section>
	<?php } ?>
	<section class="m-top08 goods-evaluation">
		<a href="javascript:;">
			<div class="dis-box padding-all b-color-f  g-evaluation-title">
				<div class="box-flex">
					<h3 class="my-u-title-size">推荐产品</h3> </div>
			</div>
		</a>

		<section class="product-list_s product-list j-product-list product-list-medium">
			<script id="j-product" type="text/html">
				<%if totalPage > 0%>
				<ul>
					<%each list as goods%>
					<li>
						<div class="product-div">
							<a class="product-div-link" href="<%goods.url%>"></a>
							<img class="product-list-img" src="<%goods.goods_thumb%>">
							<div class="product-text index-product-text">
								<h4><%goods.goods_name%></h4>
								<p class="dis-box p-t-remark"><span class="box-flex">库存:<%goods.goods_number%></span><span class="box-flex">销量:<%goods.sales_volume%></span></p>
								<p><span class="p-price t-first ">
                        <%if goods.promote_price%>
                            <%#goods.promote_price%>
                        <%else%>
                            <%#goods.shop_price%>
                        <%/if%>
                        <small><del><%#goods.market_price%></del></small>
                    </span></p>
								<a href="javascript:void(0)" class="icon-flow-cart fr j-goods-attr" onclick="addToCart(<%goods.goods_id%>, 0)"><i class="iconfont icon-gouwuche"></i></a>
							</div>
						</div>
					</li>
					<%/each%>
				</ul>
				<%else%>
				<div class="no-div-message">
					<i class="iconfont icon-biaoqingleiben"></i>
					<p>亲，此处没有内容～！</p>
				</div>
				<%/if%>
			</script>
		</section>
	</section>

	<script type="text/javascript">
		//异步数据
		$(function() {
			var url = "<?php echo url('goods', array('id'=>$info['act_id']));?>";
			//订单列表
			$('.product-list_s').infinite({
				url: url,
				template: 'j-product'
			});
		})
	</script>
</div>
	<script>
    $(function(){
       // 获取节点
          var block = document.getElementById("ectouch-top");
          var oW,oH;
          // 绑定touchstart事件
          block.addEventListener("touchstart", function(e) {
           var touches = e.touches[0];
           //oW = touches.clientX - block.offsetLeft;
           oH = touches.clientY - block.offsetTop;
           //阻止页面的滑动默认事件
           document.addEventListener("touchmove",defaultEvent,false);
          },false)
         
          block.addEventListener("touchmove", function(e) {
           var touches = e.touches[0];
           //var oLeft = touches.clientX - oW;
           var oTop = touches.clientY - oH;
          //  if(oLeft < 0) {
          //   oLeft = 0;
          //  }else if(oLeft > document.documentElement.clientWidth - block.offsetWidth) {
          //   oLeft = (document.documentElement.clientWidth - block.offsetWidth);
          //  }
          // block.style.left = oLeft + "px";
           block.style.top = oTop + "px";
          var max_top = block.style.top =oTop;
          if(max_top < 30){
             block.style.top = 30 + "px";
          }
          if(max_top > 440){
            block.style.top = 440 + "px";
          }
          },false);
           
          block.addEventListener("touchend",function() {
           document.removeEventListener("touchmove",defaultEvent,false);
          },false);
          function defaultEvent(e) {
           e.preventDefault();
          }
    })
</script>
<nav class="commom-nav dis-box ts-5" id="ectouch-top">
        <div class="left-icon">
            <div class="nav-icon"><i class="iconfont icon-jiantou1"></i>快速导航</div>
            <div class="filter-top filter-top-index" id="scrollUp">
                <i class="iconfont icon-jiantou"></i>
                <span>顶部</span>
            </div>
        </div>
        <div class="right-cont box-flex">
            <ul class="nav-cont">
                <li>
                      <a href="<?php echo url('/');?>">
                        <i class="iconfont icon-home"></i>
                        <p>首页</p>
                      </a>  
                </li>
                <li>
                    <a href="<?php echo url('search/index/index');?>">
                         <i class="iconfont icon-sousuo"></i>
                         <p>搜索</p>
                    </a>  
                </li>
                <li>
                     <a href="<?php echo url('category/index/index');?>">
                         <i class="iconfont icon-caidan"></i>
                         <p>分类</p>
                     </a> 
                </li>
                <li>
                     <a href="<?php echo url('cart/index/index');?>">
                         <i class="iconfont icon-gouwuche"></i>
                         <p>购物车</p>
                      </a> 
                </li>
                <li>
                    <a href="<?php echo url('user/index/index');?>">
                         <i class="iconfont icon-geren"></i>
                         <p>个人中心</p>
                    </a> 
                </li>
 
	<li>
        <a href="<?php echo url('activity/index/index');?>">
             <i class="iconfont icon-cuxiao"></i>
              <p>活动页</p>
        </a> 
    </li>  
                </ul>
        </div>
    </nav>
    <div class="common-show"></div> 
<!--悬浮菜单e-->
</body>

</html>