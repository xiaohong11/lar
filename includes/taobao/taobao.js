$(function(){

	//操作提示展开收起
	$("#explanationZoom").on("click",function(){
		var explanation = $(this).parents(".explanation");
		var width = $(".content").width();
		if($(this).hasClass("shopUp")){
			$(this).removeClass("shopUp");
			$(this).attr("title","收起提示");
			explanation.find(".ex_tit").css("margin-bottom",10);
			explanation.animate({
				width:width-28
			},300,function(){
				$(".explanation").find("ul").show();
			});
		}else{
			$(this).addClass("shopUp");
			$(this).attr("title","提示相关设置操作时应注意的要点");
			explanation.find(".ex_tit").css("margin-bottom",0);
			explanation.animate({
				width:"100"
			},300);
			explanation.find("ul").hide();
		}
	});

	//div仿select下拉选框 start
	$(document).on("click",".imitate_select .cite",function(){
		$(".imitate_select ul").hide();
		$(this).parents(".imitate_select").find("ul").show();
		$(this).siblings("ul").perfectScrollbar("destroy");
		$(this).siblings("ul").perfectScrollbar();
	});
	
	$(document).on("click",".imitate_select li  a",function(){
		var _this = $(this);
		var val = _this.attr('data-value');
		var text = _this.html();
		_this.parents(".imitate_select").find(".cite").html(text);
		_this.parents(".imitate_select").find("input[type=hidden]").val(val);
		_this.parents(".imitate_select").find("ul").hide();


		if ( _this.parents(".imitate_select").find("input[type=hidden]").attr('id')=='goods_id_val' ){
			
			$.getJSON('collect_goods.php', 'act=get_comment_url&goods_id='+val, function(data){
				 $("#taobao_id_url").val(data.content);
				 $("#comment_id_num").text(data.num);
				 $("#comment_id_num").on("click",function(){dm299_comment_manage(val)});
			});

		}
	});
	//div仿select下拉选框 end


	$(document).click(function(e){
		/*
		**点击空白处隐藏展开框	
		*/
		//分类
		if(e.target.id !='category_name' && !$(e.target).parents("div").is(".select-container")){
			$('.categorySelect .select-container').hide();
		}
		//仿select
		if(e.target.className !='cite' && !$(e.target).parents("div").is(".imitate_select")){
			$('.imitate_select ul').hide();
		}
	});
        
	//select下拉默认值赋值
	$('.imitate_select').each(function()
	{
		var sel_this = $(this)
		var val = sel_this.children('input[type=hidden]').val();
		sel_this.find('a').each(function(){
			if($(this).attr('data-value') == val){
				sel_this.children('.cite').html($(this).html());
			}
		})
	});


	//清理重复项和删除项
	$("#chk_collect_goods").on("click",function(){
		pb({
			id:"chk_collect_goods_dialog",
			title:"温馨提示",
			width:588,
			content:"<div id='chk_collect_goods_content' style='padding:20px 0px;'>正在清理数据，请稍后…</div>",
			ok_title:"确定",
			drag:false,
			foot:false,
			cl_cBtn:false,
		});
		$.get("collect_goods.php?act=chk_collect_goods", function(data){ 
			$("#chk_collect_goods_content").html(data)});
	});

	// 检查版本号
	$("#CHK_DM299_VERSION").on("click",function(){
		pb({
			id:"chk_dm299_version_dialog",
			title:"版本信息",
			width:588,
			content:"<div id='chk_dm299_version_content' style='padding:20px 0px;line-height:26px;'>正在检查版本信息，请稍后…</div>",
			ok_title:"确定",
			drag:false,
			foot:false,
			cl_cBtn:false,
		});
		$.get("collect_goods.php?act=chk_dm299_version", function(data){ 
			$("#chk_dm299_version_content").html(data)});
	});



/*分类搜索的下拉列表*/
	$(document).on("click",'.selection input[name="category_name"]',function(){
		$(this).parents(".selection").next('.select-container').show();
		$(".select-list").perfectScrollbar("destroy");
		$(".select-list").perfectScrollbar();
	});
		
	$(document).on('click', '.select-list li', function(){
		var obj = $(this);
		var cat_id = obj.data('cid');
		var cat_name = obj.data('cname');
		

		$.getJSON('collect_goods.php', 'act=filter_category&cat_id='+cat_id, function(data){
			if(data.content){
				obj.parents(".categorySelect").find("input[data-filter=cat_name]").val(data.cat_nav); //修改cat_name
				obj.parents(".select-container").html(data.content);
				$(".select-list").perfectScrollbar("destroy");
				$(".select-list").perfectScrollbar();
			}
		});
		obj.parents(".categorySelect").find("input[data-filter=cat_id]").val(cat_id); //修改cat_id
		
		var cat_level = obj.parents(".categorySelect").find(".select-top a").length; //获取分类级别
		if(cat_level >= 3){
			$('.categorySelect .select-container').hide();		
		}
	});

	//点击a标签返回所选分类 by wu
	$(document).on('click', '.select-top a', function(){

		var obj = $(this);
		var cat_id = obj.data('cid');
		var cat_name = obj.data('cname');
		
		$.getJSON('collect_goods.php', 'act=filter_category&cat_id='+cat_id, function(data){
			if(data.content){
				obj.parents(".categorySelect").find("input[data-filter=cat_name]").val(data.cat_nav); //修改cat_name
				obj.parents(".select-container").html(data.content);
				$(".select-list").perfectScrollbar("destroy");
				$(".select-list").perfectScrollbar();
			}
		});
		obj.parents(".categorySelect").find("input[data-filter=cat_id]").val(cat_id); //修改cat_id
	});	
	/*分类搜索的下拉列表end*/







});
	

// 评论管理 弹出
function dm299_comment_manage(goods_id)
{
	if ( goods_id )
	{
		pb({
			id:"chk_collect_goods_dialog",
			title:"评论管理",
			width:858,
			height:460,
			content:'<iframe style="width:100%;height:100%;" frameborder=0 src="collect_goods.php?act=comment_manage&goods_id='+goods_id+'"></iframe>',
			drag:false,
			foot:false,
			cl_cBtn:false,
		});
		$('#chk_collect_goods_dialog .pb-bd').css('padding','0')
	}
}


function searchGoods()
{
	var filter = new Object;
	filter.cat_id   = document.forms['theForm'].elements['category_id'].value;
	filter.brand_id = document.forms['theForm'].elements['brand_id'].value;
	filter.keyword = document.forms['theForm'].elements['keywords'].value; 

	$.getJSON('snatch.php?is_ajax=1&act=search_goods&JSON='+JSON.stringify(filter),function(result){ 
		$("#goods_id").children("ul").find("li").remove();
		var goods = result.content.goods;
		if (goods)
		{
			for (i = 0; i < goods.length; i++)
			{
				$("#goods_id").children("ul").append("<li><a href='javascript:;' data-value='"+goods[i].goods_id+"' class='ftx-01'>"+goods[i].goods_name+"</a></li>")
			}
			$("#goods_id").children("ul").show();
		}
	});
}


// 访问淘宝
function visit_taobao(id){
	var url = $('#'+id).val();
	if (url=='') return ;
	var RegUrl = new RegExp(); 
	RegUrl.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");//jihua.cnblogs.com 
	if (!RegUrl.test(url)) { 
		url = "http://item.taobao.com/item.htm?id="+url+"#detail";
	}
	window.open(url);
}




