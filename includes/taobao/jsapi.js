

// 采集弹出
function dm299_comment(goods_id,goods_name)
{
	$.getJSON('collect_goods.php', 'act=get_comment_url&goods_id='+goods_id, function(data){
		var str ='<div class="dm299-mian-info">'+
				'	 <div class="item">'+
				'		<div class="label">商品名称：</div>'+
				'		<div class="label_value" style="line-height:30px;">'+goods_name+'</div>'+
				'	</div>'+
				'	 <div class="item">'+
				'		<div class="label"><em style="color: #ec5151;margin-right: 3px;">*</em>淘宝/天猫商品URL：</div>'+
				'		<div class="label_value"><input type="text" value="'+data.content+'" class="text" id="dm299_comment_id"/><a href="javascript:visit_taobao(\'dm299_comment_id\');" class="button_dm299">访问淘宝</a></div>'+
				'	</div>'+
				'	<div class="item">'+
				'		<div class="label">抓取评价数：</div>'+
				'		<div class="label_value"><input type="text" id="dm299_comment_cnum" value="5" class="text" style="width:150px;" /><div class="notic">已有 <a href="javascript:dm299_comment_manage('+goods_id+');" style="color:red" id="comment_id_num">'+data.num+'</a> 条评论</div></div>'+
				'	</div>'+
				'	<div class="item">'+
				'		<div class="label">&nbsp;</div>'+
				'		<div class="label_value"><input value="采集" class="button_dm299" type="button" onclick="dm299_comment_submit('+goods_id+')"></div>'+
				'	</div>'+
				'</div>';

				pb({
					id:"chk_collect_goods_dialog",
					title:"采集评论",
					width:658,
					height:238,
					content:str,
					drag:false,
					foot:false,
					cl_cBtn:false,
				});
		});
};

// 评论管理 弹出
function dm299_comment_manage(goods_id)
{
	if ( goods_id )
	{
		pb({
			id:"chk_collect_comment_dialog",
			title:"评论管理",
			width:858,
			height:460,
			content:'<iframe style="width:100%;height:100%;" frameborder=0 src="collect_goods.php?act=comment_manage&goods_id='+goods_id+'"></iframe>',
			drag:false,
			foot:false,
			cl_cBtn:false,
		});
		$('#chk_collect_comment_dialog .pb-bd').css('padding','0')
	}
}


// 采集弹出
function dm299_comment_submit(goods_id)
{

	var id = $('#dm299_comment_id').val();
	var cnum = $('#dm299_comment_cnum').val();
	if ( id.length<2 )
	{
		alert('请正确填写淘宝/天猫商品URL');
		return false;
	}
	$('#chk_collect_goods_dialog .pb-bd').css('padding','0')
	$('#chk_collect_goods_dialog .pb-ct').html('<iframe style="width:100%;height:100%;" frameborder=0 src="collect_goods.php?is_iframe=1&act=get_comment&id='+id+'&cnum='+cnum+'&goods_id='+goods_id+'"></iframe>')
};

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

