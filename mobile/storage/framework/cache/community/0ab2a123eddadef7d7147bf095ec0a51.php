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

<div class="con mb-7">
    <!--头部导航-->
    <section class="b-color-f my-nav-box community">
        <div class=" t-s-i-title-1 dis-box my-dingdan purse-f">
            <a href="<?php echo url('community/index/list', array('type'=>3));?>" class="box-flex">
                <ul class="dis-box">
                    <li class="theme-left">
                    <div class="theme-box tm-zs">
                        <i class="iconfont icon-quanzi"></i></div>
                    </li>
                    <li class="box-flex">
                    <h4 class="ellipsis-one">圈子贴</h4>
                    <p class="t-remark3"><?php echo ($quan['num']); ?>条</p>
                   <!-- <?php if($quan['has_new']) { ?>
                    <div class="purse-ts-box" style="display:block"></div>
                    <?php } ?>-->
                    </li>
                </ul>
            </a>
            <a href="<?php echo url('community/index/list', array('type'=>2));?>" class="box-flex">
                <ul class="dis-box">
                    <li class="theme-left">
                    <div class="theme-box tm-ls"><i class="iconfont icon-wenda"></i></div>
                    </li>
                    <li class="box-flex">
                    <h4 class="ellipsis-one">问答贴</h4>
                    <p class="t-remark3"><?php echo ($wen['num']); ?>条</p>
                    <!--<?php if($wen['has_new']) { ?>
                    <div class="purse-ts-box" style="display:block"></div>
                    <?php } ?>-->
                    </li>
                </ul>
            </a>
        </div>
        <div class=" t-s-i-title-1 dis-box my-dingdan purse-f">
            <a href="<?php echo url('community/index/list', array('type'=>1));?>" class="box-flex">
                <ul class="dis-box">
                    <li class="theme-left">
                    <div class="theme-box tm-ns"><i class="iconfont icon-xiao36"></i></div>
                    </li>
                    <li class="box-flex">
                    <h4 class="ellipsis-one">讨论贴</h4>
                    <p class="t-remark3"><?php echo ($tao['num']); ?>条</p>
                    <!--<?php if($tao['has_new']) { ?>
                    <div class="purse-ts-box" style="display:block"></div>
                    <?php } ?>-->
                    </li>
                </ul>
            </a>
            <a href="<?php echo url('community/index/list', array('type'=>4));?>" class="box-flex">
                <ul class="dis-box">
                    <li class="theme-left">
                    <div class="theme-box tm-hs"><i class="iconfont icon-paizhao"></i></div>
                    </li>
                    <li class="box-flex">
                    <h4 class="ellipsis-one">晒单贴</h4>
                    <p class="t-remark3"><?php echo ($sun['num']); ?>条</p>
                    <?php if($sun['has_new']) { ?>
                    <div class="purse-ts-box" style="display:block"></div>
                    <?php } ?>
                    </li>
                </ul>
            </a>
        </div>
    </section>
    <!--晒单列表-->
<div class="community-list">
    <script id="j-product" type="text/html">
        <%if totalPage > 0%>
        <%each list as val%>
        <section class="com-nav m-top06" id="delete_mycom<%val.dis_id%>">
                <%if action == 'index' ||  $action == 'list'%>
                <ul class="dis-box padding-all">
                    <li class="com-left">
                        <div class="com-left-box"><img src="<%val.user_picture%>"></div>
                    </li>
                    <li class="box-flex">
                        <div class="com-adm-box new-t">
                            <h4><%val.user_name%></h4>
                        </div>
                    </li>
                    <li>
                        <div class="t-time"><i class="iconfont icon-shijian my-com-size"></i><span><%val.add_time%></span></div>
                    </li>
                </ul>
                <%else%>
                <div class="dis-box padding-all">
                    <div class="box-flex position-rel">
                        <a href="<%val.url%>" class="link-abs"> </a>
                            <div class="com-left-box fl"><img src="<%val.user_picture%>"></div>
                            <div class="fl com-adm-box">
                                <h4><%val.user_name%></h4>
                                <p><%val.add_time%></p>
                            </div>
                    </div>
                    <span><i class="iconfont icon-xiao10 my-com-size" onclick="delete_com(<%val.dis_type%>,<%val.dis_id%>)"></i></span>
                </div>
                <%/if%>
            <div class="margin-lr com-min-tit position-rel">
                <a href="<%val.url%>" class="link-abs"> </a>
                <%if val.dis_type == 1%>
                <em class="em-promotion-1 tm-ns">讨</em>
                <%else if val.dis_type == 2%>
                <em class="em-promotion-1 tm-ls">问</em>
                <%else if val.dis_type == 3%>
                <em class="em-promotion-1">圈</em>
                <%else if val.dis_type == 4%>
                <em class="em-promotion-1 tm-hs-1">晒</em>
                <%/if%>
                <span> <%val.dis_title%></span>
            </div>
            <div class="com-list dis-box text-center">
                <div class="box-flex" onClick="tz_dianzan(<%val.dis_type%>,<%val.dis_id%>)">
                    <a href="javascript:;" id="red<%val.dis_id%>" <%if val.islike == 1%>
                    class="active"<%else%><%/if%>>
                    <div class="com-icon">
                        <i class="iconfont icon-zan"></i>
                        <span id="like_num<%val.dis_id%>"><%val.like_num%></span>
                        <input id="islike<%val.dis_id%>" type="hidden" id="<%val.dis_id%>" name="islike"
                               value="<%val.islike%>"/>
                        <input id="isclick" type="hidden" name="isclick" value="0"/>
                    </div>
                    </a>
                </div>
                <div class="box-flex">
                    <a href="<%val.url%>">
                        <div class="com-icon"><i
                                class="iconfont icon-daipingjia"></i><span><%val.community_num%></span></div>
                    </a>
                </div>

                <div class="box-flex">
                    <a href="javascript:;">
                        <div class="com-icon"><i
                                class="iconfont icon-liulan"></i><span><%val.dis_browse_num%></span></div>
                    </a>
                </div>
            </div>
        </section>
        <%/each%>
        <%else%>
        <div class="no-div-message">
            <i class="iconfont icon-biaoqingleiben"></i>
            <p>亲，此处没有内容～！</p>
        </div>
        <%/if%>
    </script>
</div>
<div class="mask-filter-div"></div>
<!--尾部浮动导航-->
<footer class="com-nav-footer">
    <div class="com-list-footer dis-box text-center com-list-1">
        <a href="<?php echo url('community/index/index');?>" class="box-flex <?php if($action == 'index' || $action == 'list') { ?>active<?php } ?>">
            <p><i class="iconfont icon-medal tm-icon-size"></i></p>
            <p>贴子</p>
        </a>
        <a href="<?php echo url('community/post/index');?>" class="box-flex active foot-paizhao ">
            <div class="foot-paizhao">
                <p class="tm-img-paizhao"><i class="iconfont icon-paizhao"></i></p>
            </div>
        </a>
        <a href="<?php echo url('community/index/my');?>" class="box-flex <?php if($action == 'my') { ?>active<?php } ?>">
            <p><i class="iconfont icon-geren tm-icon-size"></i></p>
            <p>我</p>
        </a>
    </div>
</footer>
</div>
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
 
     <li>
        <a href="<?php echo url('community/index/index');?>">
            <i class="iconfont icon-medal"></i>
            <p>社区圈子</p>
        </a> 
     </li>
                </ul>
        </div>
    </nav>
    <div class="common-show"></div> 
<!--引用js-->
<script>
    function delete_com(dis_type, dis_id) {
        layer.open({
            content: '确实要删除该帖吗？',
            btn: ['删除', '取消'],
            shadeClose: false,
            yes: function (index) {
                $.ajax({
                    type: "post",
                    url: "<?php echo url('community/index/deletemycom');?>",
                    data: {dis_type: dis_type, dis_id: dis_id},
                    dataType: "json",
                    success: function (data) {
                        if (data.error == 0) {
                            $("#delete_mycom" + dis_id).remove('');
                            $.each($(".oncle-color a"),function(){
                                if($(this).attr('distype') == dis_type){
                                    var a = parseInt($(this).children('p').html())-1;
                                    $(this).children('p').html(a);
                                }
                            });
                            d_messages('删除成功');
                        }else{
                            d_messages(data.msg);
                        }
                    }
                });
                layer.close(index);
            },
            no: function () {
            }
        });
    }
</script>
<script>
    function tz_dianzan(dis_type, dis_id) {
        var isclick = document.getElementById('isclick').value;
        $("#isclick").val(new Date().getTime());
        if (isclick < (new Date().getTime() - 1000)) {
            $.ajax({
                type: "post",
                url: "<?php echo url('like');?>",
                data: {dis_type: dis_type, dis_id: dis_id},
                dataType: "json",
                success: function (data) {
                    if (data) {
                        if (data.is_like == 1) {
                            $("#red" + dis_id).addClass("active");
                        } else {
                            $("#red" + dis_id).removeClass("active");
                        }
                        $("#like_num" + dis_id).html(data.like_num);
                        $("#islike" + dis_id).val(data.is_like);
                    }
                }
            });
        }
    }
</script>
</div>
<div class="goods-scoll-bg"></div>

<script>
/*店铺信息商品滚动*/
var swiper = new Swiper('.j-g-s-p-con', {
    scrollbarHide: true,
    slidesPerView: 'auto',
    centeredSlides: false,
    grabCursor: true
});
//异步数据
$(function(){
    var url = "<?php echo url('community/index/index');?>";
    $('.community-list').infinite({url: url, template:'j-product'});
})
</script>
<script>
    function change_like_number(id) {
        if($("#red" + id).hasClass("active")){
            $("#red" + id).removeClass("active");
        }else{
            $("#red" + id).addClass("active");
        }
        var isclick = document.getElementById('isclick').value;
        $("#isclick").val(new Date().getTime());
        if(isclick < (new Date().getTime()-1000)) {
            $.ajax({
                type: "post",
                url: "<?php echo url('like');?>",
                data: {article_id: id},
                dataType: "json",
                success: function (data) {
                    $("#like_num" + id).html(data.like_num);
                    $("#islike" + id).val(data.is_like);
                }
            });
        }

    }
</script>
</body>
</html>