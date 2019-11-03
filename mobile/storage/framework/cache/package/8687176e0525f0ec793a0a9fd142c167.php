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

<?php if($list) { ?>
<?php $n=1;if(is_array($list)) foreach($list as $k=>$v) { ?>
<section class="goods-shop  b-color-f no-shopping-title <?php if($k > 0) { ?>m-top04<?php } ?>">
    <div class="goods-shop-pic of-hidden padding-all wallet-bt">
        <div class="g-s-p-con product-one-list of-hidden scrollbar-none j-g-s-p-con swiper-container-horizontal">
            <div class="swiper-wrapper">
                <?php $n=1;if(is_array($v['goods_list'])) foreach($v['goods_list'] as $key=>$goods) { ?>
                <li class="swiper-slide <?php if($key == 0) { ?>swiper-slide-active<?php } elseif ($key == 1) { ?>swiper-slide-next<?php } ?>">
                <div class="product-div">
                    <a class="product-div-link" href="<?php echo ($goods['url']); ?>"></a>
                    <img class="product-list-img" src="<?php echo ($goods['goods_thumb']); ?>">
                    <div class="product-text m-top06">
                        <h4><?php echo ($goods['goods_name']); ?></h4>
                        <p><span class="p-price t-first "><?php echo ($goods['rank_price']); ?></span></p>
                    </div>
                </div>
                </li>
                <?php $n++;}unset($n); ?>
            </div>
        </div>
    </div>
</section>
<section class="padding-all b-color-f">
    <ul class="int-nav-box my-new-m">
        <li class="int-max-tit"><?php echo ($v['act_name']); ?> (<span><?php echo ($v['package_number']); ?>件</span>)<span class="t-jiantou fr"><i class="iconfont icon-jiantou tf-180 jian-top int-jt-box"></i></span></li>
        <li class="int-title">原价：<del><?php echo ($v['subtotal']); ?></del></li>
        <li class="int-title">套餐价：<span class="int-nav-box"><?php echo ($v['package_price']); ?></span>(已优惠 <?php echo ($v['saving']); ?>)</li>
    </ul>
    <ul class="int-cont" style="display:none">
        <li>起止时间：<?php echo ($v['start_time']); ?>～<?php echo ($v['end_time']); ?></li>
        <li>简单描述：<?php echo ($v['act_desc']); ?></li>
    </ul>
    <section class="dis-box int-but-top">
        <a class="btn-submit box-flex br-5 min-btn" onclick="javascript:addPackageToCart(<?php echo ($v['act_id']); ?>, <?php echo $area_id; ?>, <?php echo $region_id; ?>)">立即购买</a>
    </section>
</section>
<input name="confirm_type" id="confirm_type" type="hidden" value="3" />
<?php $n++;}unset($n); ?>
<?php } else { ?>
   <div class="no-div-message">
                        <i class="iconfont icon-biaoqingleiben"></i>
                        <p>亲，此处没有内容～！</p>
   </div>
<?php } ?>
     <!--快捷导航-->
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
 
                </ul>
        </div>
    </nav>
    <div class="common-show"></div>
<script>
$(function($) {
    $(".int-nav-box").click(function() {
        $(this).find(".int-jt-box").toggleClass("current");					
        $(".int-cont").toggle();			
    });
    $(".int-nav-box-1").click(function() {
        $(this).find(".int-jt-box").toggleClass("current");					
        $(".int-cont-1").toggle();
    });
});
/*商品详情相册切换*/
var swiper = new Swiper('.goods-photo', {
paginationClickable: true,
onInit: function(swiper) {
document.getElementById("g-active-num").innerHTML = swiper.activeIndex + 1;
document.getElementById("g-all-num").innerHTML = swiper.slides.length;
},
onSlideChangeStart: function(swiper) {
document.getElementById("g-active-num").innerHTML = swiper.activeIndex + 1;
}
});
/*店铺信息商品滚动*/
var swiper = new Swiper('.j-g-s-p-con', {
scrollbarHide: true,
slidesPerView: 'auto',
centeredSlides: false,
grabCursor: true
});
</script>
</body>
</html>