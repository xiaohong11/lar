<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
    <title><?php echo $page_title; ?></title>
    <link rel=stylesheet href="//at.alicdn.com/t/font_u366719ytlat6gvi.css" media="screen" title="no title">
    <link rel=stylesheet href="//at.alicdn.com/t/font_lkv63qpdlo8khuxr.css" media="screen" title="no title">
    <link href="/mobile/public/css/app.css?v=<?=date('Ymd')?>" rel=stylesheet>
    <style>
		.picture-tile ul li{
			padding-bottom:0 !important;
			padding-right:0 !important;
			padding-left:0 !important;
		}
		.picture-tile ul{
			padding-top:0;
			padding:0;
		}
		.picture-tile ul li img{
			display:block;
		}
		.product-list figure h4 {
		    height:3.8rem;
		    line-height: 1.9rem;
		}
		.mod-nav nav ul li img {
		    width: 100%;
		}

    </style>
    <script>
        window.ROOT_URL = '/mobile/';
        window.PC_URL = '/';
        //首页app下载连接
        window.APP_DOWNLOAD_URL = '';
         window.shopInfo = {ru_id :0,authority:1};
    </script>
</head>
<body>
<div id="app"></div>
<script src="//3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script type="text/javascript" src="/mobile/public/js/manifest.js?v=<?=date('Ymd')?>"></script>
<script type="text/javascript" src="/mobile/public/js/vendor.js?v=<?=date('Ymd')?>"></script>
<script type="text/javascript" src="/mobile/public/js/app.js?v=<?=date('Ymd')?>"></script>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<?php if($is_wechat) { ?>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript">
    // 分享内容
    var shareContent = {
        title: '<?php echo ($share_data['title']); ?>',
        desc: '<?php echo ($share_data['desc']); ?>',
        link: '<?php echo ($share_data['link']); ?>',
        imgUrl: '<?php echo ($share_data['img']); ?>'
    };
    $(function(){
        var url = window.location.href;
        var jsConfig = {
            debug: false,
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
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
</body>
<script>
window.onload=function(){
		//头部导航
		$(window).scroll(function() {
			if($(window).scrollTop() > 100) {
				$("header.search-fixed,header.search-fixed .search-mask,header.search-fixed .search-center,.mod-search .search-left,.mod-search .search-right,.ect-header-banner").addClass("active");
			} else {
				$("header.search-fixed,header.search-fixed .search-mask,header.search-fixed .search-center,.mod-search .search-left,.mod-search .search-right,.ect-header-banner").removeClass("active");
			}
		});

		/*页面向上滚动js*/
		$(".filter-top").click(function() {
			$("html,body").animate({
				scrollTop: 0
			}, 200);
		});

		$(window).scroll(function() {
			var prevTop = 0,
				currTop = 0;
			currTop = $(window).scrollTop();
			win_height = $(window).height() * 2;
			if(currTop >= win_height) {
				$(".filter-top").stop().fadeIn(200);
			} else {
				$(".filter-top").stop().fadeOut(200);
			}
			//prevTop = currTop; //IE下有BUG，所以用以下方式
			setTimeout(function() {
				prevTop = currTop
			}, 0);
		});

    /*点击关闭顶部层*/
    $(".ect-header-banner i.icon-guanbi").click(function () {
        $(".app-down").hide();
    });
}
</script>
</body>
</html>