<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<?php echo $this->fetch('library/js_languages_new.lbi'); ?>
<?php if ($this->_var['store_id']): ?><link rel="stylesheet" type="text/css" href="js/calendar/calendar.min.css" /><?php endif; ?>
<link rel="stylesheet" type="text/css" href="js/perfect-scrollbar/perfect-scrollbar.min.css" />
</head>

<body class="bg-ligtGary">
    <?php echo $this->fetch('library/page_header_flow.lbi'); ?>
    <?php if ($this->_var['step'] == "cart"): ?>
    <div class="container">
        <div class="w w1200">
            <?php if ($this->_var['goods_list']): ?>
            <div class="cart-warp">
                <div class="cart-filter">
                    <div class="cart-stepflex">
                        <div class="cart-step-item curr">
                            <span>1.我的购物车</span>
                            <i class="iconfont icon-arrow-right-alt"></i>
                        </div>
                        <div class="cart-step-item">
                            <span>2.填写订单信息</span>
                            <i class="iconfont icon-arrow-right-alt"></i>
                        </div>
                        <div class="cart-step-item">
                            <span>3.成功提交订单</span>
                        </div>
                    </div>
                    <div class="sp-area store-selector">
                        <div class="text-select" id="area_address" ectype="areaSelect">
                            <span class="txt"><?php echo $this->_var['lang']['Distribution_to']; ?></span>
                            <div class="selector">
								<?php echo $this->fetch('library/goods_delivery_area.lbi'); ?>
                                <input type="hidden" value="<?php echo $this->_var['flow_region']; ?>" id="region_id" name="region_id">
                                <input type="hidden" value="" id="good_id" name="good_id">
                                <input type="hidden" value="<?php echo $this->_var['user_id']; ?>" id="user_id" name="user_id">
                                <input type="hidden" value="<?php echo $this->_var['area_id']; ?>" id="area_id" name="area_id">
                                <input type="hidden" value="<?php echo $this->_var['province_row']['region_id']; ?>" id="province_id" name="province_region_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-table">
                    <div class="cart-head">
                        <div class="column c-checkbox">
                            <div class="cart-checkbox cart-all-checkbox" ectype="ckList">
                                <input type="checkbox" id="cart-selectall" class="ui-checkbox checkboxshopAll" ectype="ckAll" />
                                <label for="cart-selectall" class="ui-label-14"><?php echo $this->_var['lang']['checkd_all']; ?></label>
                            </div>
                        </div>
                        <div class="column c-goods"><?php echo $this->_var['lang']['goods']; ?></div>
                        <div class="column c-props"></div>
                        <div class="column c-price"><?php echo $this->_var['lang']['Unit_price']; ?></div>
                        <div class="column c-quantity"><?php echo $this->_var['lang']['number_to']; ?></div>
                        <div class="column c-sum"><?php echo $this->_var['lang']['ws_subtotal']; ?></div>
                        <div class="column c-action"><?php echo $this->_var['lang']['handle']; ?></div>
                    </div>
                    <div class="cart-tbody" ectype="cartTboy">
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goodsRu');if (count($_from)):
    foreach ($_from AS $this->_var['goodsRu']):
?>
                        <div class="cart-item" ectype="shopItem">
                            <div class="shop">
                                <div class="cart-checkbox" ectype="ckList">
                                    <input type="checkbox" id="shopid_<?php echo $this->_var['goodsRu']['ru_id']; ?>" name="checkShop" class="ui-checkbox CheckBoxShop" ectype="ckShopAll" />
                                    <label for="shopid_<?php echo $this->_var['goodsRu']['ru_id']; ?>" class="ui-label-14">&nbsp;</label>
                                </div>
                                <div class="shop-txt">
									<?php if ($this->_var['goodsRu']['ru_id'] == 0): ?>
									<a href="javascript:;" class="shop-name self-shop-name"><?php echo $this->_var['goodsRu']['ru_name']; ?></a>
									<?php else: ?>
                                    <a href="<?php echo $this->_var['goodsRu']['url']; ?>" class="shop-name" target="_blank"><strong><?php echo $this->_var['goodsRu']['ru_name']; ?></strong></a>
									<?php endif; ?>
                                    
                                    <?php if ($this->_var['goodsRu']['is_IM'] == 1 || $this->_var['goodsRu']['is_dsc']): ?>
                                    	<a href="javascript:;" id="IM" onclick="openWin(this)" ru_id="<?php echo $this->_var['goodsRu']['ru_id']; ?>" class="p-kefu<?php if ($this->_var['goodsRu']['ru_id'] == 0): ?> p-c-violet<?php endif; ?>"><i class="iconfont icon-kefu"></i></a>
                                    <?php else: ?>
                                        <?php if ($this->_var['goodsRu']['kf_type'] == 1): ?>
                                        <a href="http://www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $this->_var['goodsRu']['kf_ww']; ?>&siteid=cntaobao&status=1&charset=utf-8" class="p-kefu" target="_blank"><i class="iconfont icon-kefu"></i></a>
                                        <?php else: ?>
                                        <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->_var['goodsRu']['kf_qq']; ?>&site=qq&menu=yes" class="p-kefu" target="_blank"><i class="iconfont icon-kefu"></i></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                            <div class="item-list" ectype="itemList">
                                <?php $_from = $this->_var['goodsRu']['new_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'activity');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['activity']):
?>
                                <?php if ($this->_var['activity']['act_id'] > 0): ?>
                                <div class="item-single" ectype="promoItem" id="product_promo_<?php echo $this->_var['goodsRu']['ru_id']; ?>_<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" data-actid="<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" data-ruid="<?php echo $this->_var['goodsRu']['ru_id']; ?>">
                                    <div class="item-full">
                                    <div class="item-header" ectype="prpmoHeader">
                                        <?php if ($this->_var['activity']['act_type'] == 0): ?>
                                        <div class="f-txt">
                                            <span class="full-icon"><?php echo $this->_var['activity']['act_type_txt']; ?><i class="i-arrow"></i></span>
                                            <?php if ($this->_var['activity']['act_type_ext'] == 0): ?>
                                                <?php if ($this->_var['activity']['available']): ?>
                                                <a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="ftx-03" target="_blank"><?php echo $this->_var['lang']['activity_notes_one']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['activity']; ?>， <?php echo $this->_var['lang']['receive_gifts']; ?><?php if ($this->_var['activity']['cart_favourable_gift_num'] > 0): ?>，<?php echo $this->_var['lang']['Already_receive']; ?><?php echo $this->_var['activity']['cart_favourable_gift_num']; ?><?php echo $this->_var['lang']['jian']; ?><?php endif; ?>&gt;</a>
                                                <a href="javascript:void(0);" data-actid="<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" data-ruid="<?php echo $this->_var['goodsRu']['ru_id']; ?>" id="select-gift-<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="f-btn" ectype="tradeBtn"><?php echo $this->_var['lang']['receive_gift']; ?></a>
                                                
                                                <?php else: ?>
                                                <a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="ftx-03" target="_blank"><?php echo $this->_var['lang']['activity_notes_three']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['yuan']; ?>，<?php echo $this->_var['lang']['receive_gifts']; ?> &gt; </a>
                                                <a href="javascript:void(0);" data-actid="<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" data-ruid="<?php echo $this->_var['goodsRu']['ru_id']; ?>" id="select-gift-<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="f-btn" ectype="tradeBtn"><?php echo $this->_var['lang']['see_gift']; ?></a>
												<a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="ftx-05" target="_blank">&nbsp;<?php echo $this->_var['lang']['gather_together']; ?>&nbsp;></a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($this->_var['activity']['available']): ?>
                                                <a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="ftx-03" target="_blank"><?php echo $this->_var['lang']['activity_notes_one']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['yuan']; ?> ，<?php echo $this->_var['lang']['receive_gifts']; ?><?php echo $this->_var['activity']['act_type_ext']; ?><?php echo $this->_var['lang']['jian']; ?> ，<?php echo $this->_var['lang']['receive_gifts_again']; ?><?php echo $this->_var['activity']['left_gift_num']; ?><?php echo $this->_var['lang']['jian']; ?> &gt; </a>
                                                <a href="javascript:void(0);" data-actid="<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" data-ruid="<?php echo $this->_var['goodsRu']['ru_id']; ?>" id="select-gift-<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="f-btn" ectype="tradeBtn"><?php echo $this->_var['lang']['receive_gift']; ?></a>
                                                <?php else: ?>
                                                <a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="ftx-03" target="_blank"><?php echo $this->_var['lang']['activity_notes_three']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['yuan']; ?>，<?php echo $this->_var['lang']['receive_gifts']; ?><?php echo $this->_var['activity']['act_type_ext']; ?><?php echo $this->_var['lang']['jian']; ?> &gt; </a>
                                                <a href="javascript:void(0);" data-actid="<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" data-ruid="<?php echo $this->_var['goodsRu']['ru_id']; ?>" id="select-gift-<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="f-btn" ectype="tradeBtn"><?php echo $this->_var['lang']['see_gift']; ?></a>
												<a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="ftx-05" target="_blank">&nbsp;<?php echo $this->_var['lang']['gather_together']; ?>&nbsp;></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <span class="full-txt"><?php echo $this->_var['goods']['act_name']; ?></span>
                                            <span class="f-price"><em>¥</em><?php echo $this->_var['activity']['cart_fav_amount']; ?></span>
                                        </div>
                                        <?php elseif ($this->_var['activity']['act_type'] == 1): ?>
                                        <div class="f-txt">
                                            <span class="full-icon"><i class="i-left"></i><?php echo $this->_var['activity']['act_type_txt']; ?><i class="i-right"></i></span>
                                            <?php if ($this->_var['activity']['available']): ?>
                                            <?php echo $this->_var['lang']['activity_notes_one']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['yuan']; ?>（<span class="ftx-01"><?php echo $this->_var['lang']['been_reduced']; ?><?php echo $this->_var['activity']['act_type_ext_format']; ?><?php echo $this->_var['lang']['yuan']; ?></span>）
                                            <?php else: ?>
                                            <span><?php echo $this->_var['lang']['activity_notes_three']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['activity_notes_two']; ?></span>
                                            <?php endif; ?>
                                            <a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" class="ftx-05" target="_blank"> &gt;<?php echo $this->_var['lang']['gather_together']; ?>&nbsp;</a>
                                            <span class="full-txt"><?php echo $this->_var['goods']['act_name']; ?></span>
                                            <span class="f-price"><em>¥</em><?php echo $this->_var['activity']['cart_fav_amount']; ?></span>
                                        </div>
                                        <?php elseif ($this->_var['activity']['act_type'] == 2): ?>
                                        <div class="f-txt">
                                            <span class="full-icon"><i class="i-left"></i><?php echo $this->_var['activity']['act_type_txt']; ?><i class="i-right"></i></span>
                                            <?php if ($this->_var['activity']['available']): ?>
                                            <?php echo $this->_var['lang']['activity_notes_one']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['yuan']; ?> （<?php echo $this->_var['lang']['Already_enjoy']; ?><?php echo $this->_var['activity']['act_type_ext_format']; ?><?php echo $this->_var['lang']['percent_off_Discount']; ?>）
                                            <?php else: ?>
                                            <?php echo $this->_var['lang']['activity_notes_three']; ?><?php echo $this->_var['activity']['min_amount']; ?><?php echo $this->_var['lang']['zhekouxianzhi']; ?>
                                            <?php endif; ?>
                                            <a href="coudan.php?id=<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>" target="_blank" class="ftx-05"> &gt;<?php echo $this->_var['lang']['gather_together']; ?></a>
                                            <span class="full-txt"><?php echo $this->_var['goods']['act_name']; ?></span>
                                            <span class="f-price"><em>¥</em><?php echo $this->_var['activity']['cart_fav_amount']; ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php $_from = $this->_var['activity']['act_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['act_goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['act_goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['act_goods_list']['iteration']++;
?>
                                    <div class="item-item" ectype="item" data-recid="<?php echo $this->_var['goods']['rec_id']; ?>">
                                        <div class="item-form">
                                            <div class="cell s-checkbox">
                                                <div class="cart-checkbox" ectype="ckList">
                                                    <input type="checkbox" id="checkItem_<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['rec_id']; ?>" name="checkItem" class="ui-checkbox" ectype="ckGoods"<?php if ($this->_var['goods']['is_invalid']): ?> disabled="disabled"<?php endif; ?> />
                                                    <label for="checkItem_<?php echo $this->_var['goods']['rec_id']; ?>" class="ui-label-14">&nbsp;</label>
                                                </div>
                                            </div>
                                            <div class="cell s-goods">
                                                <div class="goods-item">
                                                    <div class="p-img"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="70" height="70"></a></div>
                                                    <div class="item-msg">
                                                        <div class="p-name"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a></div>
                                                        <div class="gds-types">
                                                            <?php if ($this->_var['goods']['stages_qishu'] != - 1): ?>
                                                            <em class="gds-type gds-type-stages"><?php echo $this->_var['lang']['by_stages']; ?></em>
                                                            <?php endif; ?>
                                                            <?php if ($this->_var['goods']['is_invalid']): ?><span class="red">（已失效）</span><?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cell s-props">
                                                <?php if ($this->_var['goods']['goods_attr']): ?><?php echo nl2br($this->_var['goods']['goods_attr']); ?><?php else: ?>&nbsp;<?php endif; ?>
                                            </div>
                                            <div class="cell s-price relative">
                                                <strong id="goods_price_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['goods_price']; ?></strong>
                                            </div>
                                            <div class="cell s-quantity">
                                                <div class="amount-warp">
                                                    <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
                                                    <input type="text" value="<?php echo $this->_var['goods']['goods_number']; ?>" name="goods_number[<?php echo $this->_var['goods']['rec_id']; ?>]" id="goods_number_<?php echo $this->_var['goods']['rec_id']; ?>" onchange="change_goods_number(<?php echo $this->_var['goods']['rec_id']; ?>,this.value, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, '', <?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>)" class="text buy-num" ectype="number" defaultnumber="<?php echo $this->_var['goods']['goods_number']; ?>">
                                                    <div class="a-btn">
                                                        <a href="javascript:void(0);" onclick="changenum(<?php echo $this->_var['goods']['rec_id']; ?>, 1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, <?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>)"  class="btn-add"><i class="iconfont icon-up"></i></a>
                                                        <a href="javascript:void(0);" onclick="changenum(<?php echo $this->_var['goods']['rec_id']; ?>, -1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, <?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>)" class="btn-reduce <?php if ($this->_var['goods']['goods_number'] == 1): ?>btn-disabled<?php endif; ?>"><i class="iconfont icon-down"></i></a>
                                                    </div>
                                                    <?php else: ?>
                                                    <div class="tc" id="<?php echo $this->_var['goods']['group_id']; ?>_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['goods_number']; ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ($this->_var['goods']['attr_number']): ?>
                                                <div class="tc ftx-03"><?php echo $this->_var['lang']['Have_goods']; ?></div>
                                                <?php else: ?>
                                                <div class="tc ftx-01"><?php echo $this->_var['lang']['No_goods']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="cell s-sum">
                                                <strong id="goods_subtotal_<?php echo $this->_var['goods']['rec_id']; ?>"><font id="<?php echo $this->_var['goods']['group_id']; ?>_<?php echo $this->_var['goods']['rec_id']; ?>_subtotal"><?php echo $this->_var['goods']['formated_subtotal']; ?></font></strong>
                                                <div class="cuttip <?php if ($this->_var['goods']['dis_amount'] == 0): ?>hide<?php endif; ?>">
                                                	<span class="tit"><?php echo $this->_var['lang']['youhui']; ?></span>
                                                	<span class="price" id="discount_amount_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['discount_amount']; ?></span>
                                                </div>
                                            </div>
                                            <div class="cell s-action">
                                                <a href="javascript:void(0);" id="remove_<?php echo $this->_var['goods']['rec_id']; ?>" ectype="cartOperation" data-value='{"divId":"cart_remove","url":"flow.php?step=drop_goods&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","cancelUrl":"flow.php?step=drop_to_collect&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","recid":<?php echo $this->_var['goods']['rec_id']; ?>,"title":"<?php echo $this->_var['lang']['drop']; ?>"}' class="cart-remove"><?php echo $this->_var['lang']['drop']; ?></a>
                                                <a href="javascript:void(0);" id="store_<?php echo $this->_var['goods']['rec_id']; ?>" ectype="cartOperation" data-value='{"divId":"cart_collect","url":"flow.php?step=drop_to_collect&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","recid":<?php echo $this->_var['goods']['rec_id']; ?>,"title":"<?php echo $this->_var['lang']['follow']; ?>"}' class="cart-store"><?php echo $this->_var['lang']['collect']; ?></a>
                                            </div>
                                        </div>
                                       	<?php if ($this->_foreach['act_goods_list']['iteration'] > 1): ?>
                                        <div class="item-line"></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    
                                    <?php $_from = $this->_var['activity']['act_cart_gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                                    <div class="item-item zp" ectype="item" data-recid="<?php echo $this->_var['goods']['rec_id']; ?>">
                                        <div class="item-form">
                                            <div class="cell s-checkbox">&nbsp;
                                                <div class="cart-checkbox hide <?php echo $this->_var['goods']['group_id']; ?>" ectype="ckList">
                                                    <input type="checkbox" id="checkItem_<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['rec_id']; ?>" name="checkItem" class="ui-checkbox" ectype="ckGoods"<?php if ($this->_var['goods']['is_invalid']): ?> disabled="disabled"<?php endif; ?> />
                                                    <label for="checkItem_<?php echo $this->_var['goods']['rec_id']; ?>" class="ui-label-14">&nbsp;</label>
                                                </div>
                                            </div>
                                            <div class="cell s-goods">
                                                <div class="goods-item">
                                                    <div class="p-img">
                                                        <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
                                                        <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="70" height="70" /></a>
                                                        <?php else: ?>
                                                        <a href="javascript:void(0);" target="_blank"><img src="themes/ecmoban_dsc2017/images/17184624079016pa.jpg" width="70" height="70" /></a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="item-msg">
                                                    	<?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
                                                        <div class="p-name package-name"><?php echo $this->_var['goods']['goods_name']; ?><span class="red">（<?php echo $this->_var['lang']['remark_package']; ?>）</span></div>
                                                        <div class="package_goods" id="suit_<?php echo $this->_var['goods']['goods_id']; ?>">
                                                            <div class="title">包含商品：</div>
                                                            <ul>
                                                                <?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');$this->_foreach['nopackage'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nopackage']['total'] > 0):
    foreach ($_from AS $this->_var['package_goods_list']):
        $this->_foreach['nopackage']['iteration']++;
?>
                                                                <li>
                                                                	<div class="goodsName"><a href="goods.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>" target="_blank"><?php echo $this->_var['package_goods_list']['goods_name']; ?></a></div>
                                                                    <div class="goodsNumber">x<?php echo $this->_var['package_goods_list']['goods_number']; ?></div>
                                                                </li>
                                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                                            </ul>
                                                        </div>
                                                        <?php else: ?>
                                                        <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a>
                                                        <?php endif; ?>
                                                        
                                                        <div class="gds-types">
                                                            <em class="gds-type gds-type-stages"><?php echo $this->_var['lang']['largess']; ?></em>
                                                            <?php if ($this->_var['goods']['is_invalid']): ?><span class="red">（已失效）</span><?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cell s-props">
                                                <?php if ($this->_var['goods']['goods_attr']): ?><?php echo nl2br($this->_var['goods']['goods_attr']); ?><?php else: ?>&nbsp;<?php endif; ?>
                                            </div>
                                            <div class="cell s-price">
                                                <strong id="goods_price_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['goods_price']; ?></strong>
                                            </div>
                                            <div class="cell s-quantity">
                                                <div class="amount-warp">
                                                    <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
                                                    <input type="text" value="<?php echo $this->_var['goods']['goods_number']; ?>" name="goods_number[<?php echo $this->_var['goods']['rec_id']; ?>]" id="goods_number_<?php echo $this->_var['goods']['rec_id']; ?>" onchange="change_goods_number(<?php echo $this->_var['goods']['rec_id']; ?>,this.value, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, '', <?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>)" class="text buy-num" ectype="number" defaultnumber="<?php echo $this->_var['goods']['goods_number']; ?>">
                                                    <div class="a-btn">
                                                        <a href="javascript:void(0);" onclick="changenum(<?php echo $this->_var['goods']['rec_id']; ?>, 1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, <?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>)"  class="btn-add"><i class="iconfont icon-up"></i></a>
                                                        <a href="javascript:void(0);" onclick="changenum(<?php echo $this->_var['goods']['rec_id']; ?>, -1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, <?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>)" class="btn-reduce <?php if ($this->_var['goods']['goods_number'] == 1): ?>btn-disabled<?php endif; ?>"><i class="iconfont icon-down"></i></a>
                                                    </div>
                                                    <?php else: ?>
                                                    <input type="text" value="<?php echo $this->_var['goods']['goods_number']; ?>" class="noeidx" ectype="number" readonly id="<?php echo $this->_var['goods']['group_id']; ?>_<?php echo $this->_var['goods']['rec_id']; ?>" />
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="cell s-sum">
                                                <strong id="goods_subtotal_<?php echo $this->_var['goods']['rec_id']; ?>"><font id="<?php echo $this->_var['goods']['group_id']; ?>_<?php echo $this->_var['goods']['rec_id']; ?>_subtotal"><?php echo $this->_var['goods']['formated_subtotal']; ?></font></strong>
                                                <div class="cuttip <?php if ($this->_var['goods']['dis_amount'] == 0): ?>hide<?php endif; ?>">
                                                	<span class="tit"><?php echo $this->_var['lang']['youhui']; ?></span>
                                                    <span class="price" id="discount_amount_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['discount_amount']; ?></span>
                                                </div>
                                            </div>
                                            <div class="cell s-action">
                                                <a href="javascript:void(0);" id="remove_<?php echo $this->_var['goods']['rec_id']; ?>" ectype="cartOperation" data-value='{"divId":"cart_remove","url":"flow.php?step=drop_goods&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","cancelUrl":"flow.php?step=drop_to_collect&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","recid":<?php echo $this->_var['goods']['rec_id']; ?>,"title":"<?php echo $this->_var['lang']['drop']; ?>"}' class="cart-remove"><?php echo $this->_var['lang']['drop']; ?></a>
                                                <a href="javascript:void(0);" id="store_<?php echo $this->_var['goods']['rec_id']; ?>" ectype="cartOperation" data-value='{"divId":"cart_collect","url":"flow.php?step=drop_to_collect&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","recid":<?php echo $this->_var['goods']['rec_id']; ?>,"title":"<?php echo $this->_var['lang']['follow']; ?>"}' class="cart-store"><?php echo $this->_var['lang']['collect']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    
                                    <?php if ($this->_var['activity']['act_gift_list']): ?>
                                    <div class="gift-box" ectype="giftBox" id="gift_box_list_<?php echo empty($this->_var['activity']['act_id']) ? '0' : $this->_var['activity']['act_id']; ?>_<?php echo $this->_var['goods']['ru_id']; ?>" style="display:none;">
                                        <?php echo $this->fetch('library/cart_gift_box.lbi'); ?>
                                    </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="item-single">
                                <?php $_from = $this->_var['activity']['act_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                                	<div class="item-item<?php if ($this->_var['goods']['group_id'] && $this->_var['goods']['parent_id'] != 0): ?> zp <?php echo $this->_var['goods']['group_id']; ?><?php endif; ?>" ectype="item" id="product_<?php echo $this->_var['goods']['goods_id']; ?>" data-recid="<?php echo $this->_var['goods']['rec_id']; ?>" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>">
                                        <div class="item-form">
                                            <div class="cell s-checkbox">
                                                <div class="cart-checkbox<?php if ($this->_var['goods']['group_id'] && $this->_var['goods']['parent_id'] != 0): ?> hide<?php endif; ?>" ectype="ckList">
                                                    <input type="checkbox" id="checkItem_<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['rec_id']; ?>" name="checkItem" class="ui-checkbox" ectype="ckGoods"<?php if ($this->_var['goods']['is_invalid']): ?> disabled="disabled" <?php endif; ?> />
                                                    <label for="checkItem_<?php echo $this->_var['goods']['rec_id']; ?>" class="ui-label-14">&nbsp;</label>
                                                </div>
                                            </div>
                                            <div class="cell s-goods">
                                                <div class="goods-item">
                                                    <div class="p-img">
                                                        <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
                                                        <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="70" height="70" /></a>
                                                        <?php else: ?>
                                                        <a href="javascript:void(0);" target="_blank"><img src="themes/ecmoban_dsc2017/images/17184624079016pa.jpg" width="70" height="70" /></a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="item-msg">
                                                    	<?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
                                                        <div class="p-name package-name"><?php echo $this->_var['goods']['goods_name']; ?><span class="red">（<?php echo $this->_var['lang']['remark_package']; ?>）</span></div>
                                                        <div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" class="package_goods">
                                                        	<div class="title">包含商品：</div>
                                                            <ul>
                                                                <?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');$this->_foreach['nopackage'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nopackage']['total'] > 0):
    foreach ($_from AS $this->_var['package_goods_list']):
        $this->_foreach['nopackage']['iteration']++;
?>
                                                                <li>
                                                                	<div class="goodsName"><a href="goods.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>" target="_blank"><?php echo $this->_var['package_goods_list']['goods_name']; ?></a></div>
                                                                    <div class="goodsNumber">x<?php echo $this->_var['package_goods_list']['goods_number']; ?></div>
                                                                </li>
                                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                                            </ul>
                                                        </div>
                                                        <?php else: ?>
                                                        <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a>
                                                            <?php if ($this->_var['goods']['is_chain']): ?>
                                                        <p style="font-weight: bold;">（该商品支持<span style="color:green"> 门店自提 </span>服务）</p>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <div class="gds-types">
                                                            <?php if ($this->_var['goods']['stages_qishu'] != - 1): ?>
                                                            <em class="gds-type gds-type-stages"><?php echo $this->_var['lang']['by_stages']; ?></em>
                                                            <?php endif; ?>
                                                            <?php if ($this->_var['goods']['group_id'] && $this->_var['goods']['parent_id'] != 0): ?>
                                                            <em class="gds-type gds-type-store">配件</em>
                                                            <?php endif; ?>
                                                            <?php if ($this->_var['goods']['is_invalid']): ?><span class="red">（已失效）</span><?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cell s-props">
                                                <?php if ($this->_var['goods']['goods_attr']): ?><?php echo nl2br($this->_var['goods']['goods_attr']); ?><?php else: ?>&nbsp;<?php endif; ?>
                                            </div>
                                            <div class="cell s-price">
                                                <strong id="goods_price_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['goods_price']; ?></strong>
                                            </div>
                                            <div class="cell s-quantity">
                                                <div class="amount-warp">
                                                    <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0): ?>
                                                    <?php if ($this->_var['goods']['extension_code'] == 'package_buy'): ?>
                                                    <input type="text" value="<?php echo $this->_var['goods']['goods_number']; ?>" name="goods_number[<?php echo $this->_var['goods']['rec_id']; ?>]" id="goods_number_<?php echo $this->_var['goods']['rec_id']; ?>" onchange="addPackageToCartFlow(<?php echo $this->_var['goods']['goods_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>, this.value, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, 2)" class="text buy-num" ectype="number" defaultnumber="<?php echo $this->_var['goods']['goods_number']; ?>">
                                                    <?php else: ?>
                                                    <input type="text" value="<?php echo $this->_var['goods']['goods_number']; ?>" name="goods_number[<?php echo $this->_var['goods']['rec_id']; ?>]" id="goods_number_<?php echo $this->_var['goods']['rec_id']; ?>" onchange="change_goods_number(<?php echo $this->_var['goods']['rec_id']; ?>, this.value, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>)" class="text buy-num" ectype="number" defaultnumber="<?php echo $this->_var['goods']['goods_number']; ?>">
                                                    <?php endif; ?>
                                                    <div class="a-btn">
                                                    	<?php if ($this->_var['goods']['extension_code'] == 'package_buy'): ?>
                                                        <a href="javascript:void(0);" onclick="addPackageToCartFlow(<?php echo $this->_var['goods']['goods_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>, 1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, 1)"  class="btn-add"><i class="iconfont icon-up"></i></a>
                                                        <a href="javascript:void(0);" onclick="addPackageToCartFlow(<?php echo $this->_var['goods']['goods_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>, -1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>, 1)" class="btn-reduce <?php if ($this->_var['goods']['goods_number'] == 1): ?>btn-disabled<?php endif; ?>"><i class="iconfont icon-down"></i></a>
                                                        <?php else: ?>
                                                        <a href="javascript:void(0);" onclick="changenum(<?php echo $this->_var['goods']['rec_id']; ?>, 1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>)"  class="btn-add"><i class="iconfont icon-up"></i></a>
                                                        <a href="javascript:void(0);" onclick="changenum(<?php echo $this->_var['goods']['rec_id']; ?>, -1, <?php echo $this->_var['goods']['warehouse_id']; ?>, <?php echo $this->_var['goods']['area_id']; ?>)" class="btn-reduce <?php if ($this->_var['goods']['goods_number'] == 1): ?>btn-disabled<?php endif; ?>"><i class="iconfont icon-down"></i></a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php else: ?>
                                                    <div class="tc" id="<?php echo $this->_var['goods']['group_id']; ?>_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['goods_number']; ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ($this->_var['goods']['attr_number'] || $this->_var['goods']['extension_code'] == 'package_buy'): ?>
                                                <div class="tc ftx-03"><?php echo $this->_var['lang']['Have_goods']; ?></div>
                                                <?php else: ?>
                                                <div class="tc ftx-01"><?php echo $this->_var['lang']['No_goods']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="cell s-sum">
                                                <strong id="goods_subtotal_<?php echo $this->_var['goods']['rec_id']; ?>"><font id="<?php echo $this->_var['goods']['group_id']; ?>_<?php echo $this->_var['goods']['rec_id']; ?>_subtotal"><?php echo $this->_var['goods']['formated_subtotal']; ?></font></strong>
                                                <div class="cuttip <?php if ($this->_var['goods']['dis_amount'] == 0): ?>hide<?php endif; ?>">
                                                	<span class="tit"><?php echo $this->_var['lang']['youhui']; ?></span>
                                                    <span class="price" id="discount_amount_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['discount_amount']; ?></span>
                                                </div>
                                            </div>
                                            <div class="cell s-action">
                                                <a href="javascript:void(0);" id="remove_<?php echo $this->_var['goods']['rec_id']; ?>" ectype="cartOperation" data-value='{"divId":"cart_remove","url":"flow.php?step=drop_goods&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","cancelUrl":"flow.php?step=drop_to_collect&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","recid":<?php echo $this->_var['goods']['rec_id']; ?>,"title":"<?php echo $this->_var['lang']['drop']; ?>"}' class="cart-remove"><?php echo $this->_var['lang']['drop']; ?></a>
                                                <a href="javascript:void(0);" id="store_<?php echo $this->_var['goods']['rec_id']; ?>" ectype="cartOperation" data-value='{"divId":"cart_collect","url":"flow.php?step=drop_to_collect&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>","recid":<?php echo $this->_var['goods']['rec_id']; ?>,"title":"<?php echo $this->_var['lang']['follow']; ?>"}' class="cart-store"><?php echo $this->_var['lang']['collect']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </div>
                        </div>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                    <?php if ($this->_var['total']['store_goods_number'] > 0): ?>
                    <div>
                        <p class="tr mt10">
                            <span>该订单中包含支持“门店自提”服务的商品，如需到店自提，请选择提交</span>
                            <a class="btn" ectype="store_order"><i class="iconfont icon-store-alt"></i> 门店自提订单</a>
                        </p>
                    </div>
                    <?php endif; ?>
                    <div class="cart-tfoot">
                    	<div class="cart-toolbar" ectype="tfoot-toolbar">
                        	<div class="w w1200">
                            <div class="cart-checkbox cart-all-checkbox" ectype="ckList">
                                <input type="checkbox" id="toggle-checkboxes-down" class="ui-checkbox checkboxshopAll" ectype="ckAll" />
                                <label for="toggle-checkboxes-down" class="ui-label-14"><?php echo $this->_var['lang']['checkd_all']; ?></label>
                            </div>
                        	<?php if ($this->_var['total']['stages_qishu']): ?>
                            <div class="select-stores-all">
                                <div class="cart-store-checkbox">
                                    <input type="checkbox" name="stages-checkboxs-all" id="stages-checkboxs-all" class="ui-checkbox stages-checkboxs-all" />
                                    <label for="stages-checkboxs-all"><?php echo $this->_var['lang']['by_stages']; ?></label>
                                </div>
                            </div>
                        	<?php endif; ?>
                            <div class="operation">
                                <a href="javascript:void(0);" class="cart-remove-batch" data-dialog="remove_collect_dialog" data-divid="cart-remove-batch" data-removeurl="ajax_dialog.php?act=delete_cart_goods" data-collecturl="ajax_dialog.php?act=drop_to_collect" data-title="<?php echo $this->_var['lang']['drop']; ?>"><?php echo $this->_var['lang']['remove_checked_goods']; ?></a>
                                <a href="javascript:void(0);" class="cart-follow-batch" data-dialog="remove_collect_dialog" data-divid="cart-collect-batch" data-removeurl="ajax_dialog.php?act=delete_cart_goods" data-collecturl="ajax_dialog.php?act=drop_to_collect" data-title="<?php echo $this->_var['lang']['follow']; ?>"><?php echo $this->_var['lang']['Move_my_collection']; ?></a>
                            </div>
                            <div class="toolbar-right">
                                <div class="comm-right">
                                    <div class="btn-area">
                                        <form name="formCart" method="post" action="flow.php" onsubmit="return get_toCart();">
                                            <input name="goPay" type="submit" class="submit-btn" value="<?php echo $this->_var['lang']['go_pay']; ?>" <?php if (! $this->_var['user_id']): ?> id="go_pay" data-url="flow.php"<?php endif; ?>/>
                                            <input name="step" value="checkout" type="hidden" />
                                            <input name="store_seller" value="" type="hidden" id="cart_store_seller" />
                                            <input name="cart_value" id="cart_value" value="<?php echo $_SESSION['cart_value']; ?>" type="hidden" />
											<input name="goods_ru" id="goods_ru" value="" type="hidden" />
                                            <input name="store_order" id="store_order" value="0" type="hidden" />
                                        </form>
                                    </div>
                                    <div class="price-sum" id="total_desc">
                                        <span class="txt"><?php echo $this->_var['lang']['title_count']; ?>：</span>
                                        <span class="price sumPrice" id="cart_goods_amount" ectype="goods_total"></span>
                                    </div>
                                    <div class="reduce-sum">
                                        <span class="txt"><?php echo $this->_var['lang']['Already_save']; ?>：</span>
                                        <span class="price totalRePrice" id="save_total_amount" ectype="save_total"></span>
                                    </div>
                                    <div class="amount-sum"><?php echo $this->_var['lang']['choose']; ?><em class="cart_check_num" ectype="cartNum">0</em><?php echo $this->_var['lang']['jian']; ?><?php echo $this->_var['lang']['goods']; ?></div>
                                </div>
                            </div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="cart-empty">
                <div class="cart-message">
                    <div class="txt">购物车快饿瘪了，主人快给我挑点宝贝吧</div>
                    <div class="info">
                        <a href="./index.php" class="btn sc-redBg-btn">马上去逛逛</a>
                        <?php if (! $this->_var['user_id']): ?><a href="javascript:void(0);" id="go_pay" data-url="flow.php" class="login">去登录</a><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="p-panel-main c-history">
                <div class="ftit ftit-delr"><h3><?php echo $this->_var['lang']['guess_love']; ?></h3></div>
                <div class="gl-list clearfix">
                    <ul class="clearfix">
                        <?php $_from = $this->_var['guess_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name']['iteration']++;
?>
                        <?php if (($this->_foreach['name']['iteration'] - 1) < 6): ?>
                        <li class="opacity_img">
                            <div class="p-img"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="190" height="190"></a></div>
                            <div class="p-price"><?php echo $this->_var['goods']['shop_price']; ?></div>
                            <div class="p-name"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['short_name']); ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></div>
                            <div class="p-num">已售<em><?php echo $this->_var['goods']['sales_volume']; ?></em>件</div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($this->_var['step'] == "checkout"): ?>
    <div class="container">
        <form action="flow.php" method="post" name="doneTheForm" class="validator" id="theForm">
            <div class="w w1200">
        	<div class="checkout-warp">
            	
                <div class="ck-step" id="consignee_list">
                	<div class="ck-step-tit">
                        <h3><?php echo $this->_var['lang']['consignee_info']; ?></h3>
                        <a href="user.php?act=address_list" class="extra-r" target="_blank">管理收货人地址</a>
                    </div>
                    <div class="ck-step-cont" id="consignee-addr">
                    <?php echo $this->fetch('library/consignee_flow.lbi'); ?>
                    </div>
                </div>
                
                
                <?php if ($this->_var['seller_store'] || $this->_var['store_seller'] == 'store_seller'): ?>
                <div class="ck-step">
                    <div class="ck-step-tit">
                    	<h3><?php echo $this->_var['lang']['offline_store_information']; ?></h3>
                    </div>      
                    <div class="ck-step-cont">
                        <div class="store-warp" ectype="storeWarp">
                            <div class="item<?php if ($this->_var['store_seller']): ?> hide<?php endif; ?>" ectype="seller_address">
                            	<?php if (! $this->_var['store_seller']): ?>
                            	<div class="item_label"><?php echo $this->_var['lang']['offline_store_information']; ?>：</div>
                                <div class="item_value">
                                    <span class="sp ftxt-01"><?php echo $this->_var['seller_store']['stores_name']; ?></span>
                                    <span class="sp">(<?php echo $this->_var['seller_store']['country']; ?>&nbsp;<?php echo $this->_var['seller_store']['stores_address']; ?>)</span>
                                    <a href="javascript:void(0);" id="store_button" ectype="storeBtn"><?php echo $this->_var['lang']['edit']; ?></a>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="item<?php if (! $this->_var['store_seller']): ?> hide<?php endif; ?>" ectype="get_seller_sotre">
                            	<div class="item_label"><?php echo $this->_var['lang']['offline_store_information']; ?>：</div>
                                <div class="item_value" ectype="regionLinkage">
                                    <dl class="mod-select mod-select-small" ectype="smartdropdown" id="selProvinces">
                                        <dt>
                                            <span class="txt" ectype="txt"><?php echo $this->_var['lang']['please_select']; ?></span>
                                            <input type="hidden" value="<?php echo $this->_var['consignee']['province']; ?>" name="province">
                                        </dt>
                                        <dd ectype="layer">
                                            <div class="option" data-value="0"><?php echo $this->_var['lang']['please_select']; ?></div>
                                            <?php $_from = $this->_var['provinces']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province_0_75598500_1572696500');if (count($_from)):
    foreach ($_from AS $this->_var['province_0_75598500_1572696500']):
?>
                                            <div class="option" data-value="<?php echo $this->_var['province_0_75598500_1572696500']['region_id']; ?>" data-text="<?php echo $this->_var['province_0_75598500_1572696500']['region_name']; ?>" data-type="2" ectype="ragionItem"><?php echo $this->_var['province_0_75598500_1572696500']['region_name']; ?></div>
                                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                        </dd>
                                    </dl>
                                    <dl class="mod-select mod-select-small" ectype="smartdropdown" id="selCities">
                                        <dt>
                                            <span class="txt" ectype="txt"><?php echo $this->_var['lang']['please_select']; ?></span>
                                            <input type="hidden" value="<?php echo $this->_var['consignee']['city']; ?>" name="city">
                                        </dt>
                                        <dd ectype="layer">
                                            <div class="option" data-value="0"><?php echo $this->_var['lang']['please_select']; ?></div>
                                            <?php $_from = $this->_var['cities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
                                            <div class="option" data-value="<?php echo $this->_var['city']['region_id']; ?>" data-type="3" data-text="<?php echo $this->_var['city']['region_name']; ?>" ectype="ragionItem"><?php echo $this->_var['city']['region_name']; ?></div>
                                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                        </dd>
                                    </dl>
                                    <dl class="mod-select mod-select-small" ectype="smartdropdown" data-store="1" id="selDistricts" style="display:none;">
                                        <dt>
                                            <span class="txt" ectype="txt"><?php echo $this->_var['lang']['please_select']; ?></span>
                                            <input type="hidden" value="<?php echo $this->_var['consignee']['district']; ?>" name="district">
                                        </dt>
                                        <dd ectype="layer">
                                            <div class="option" data-value="0"><?php echo $this->_var['lang']['please_select']; ?></div>
                                            <?php $_from = $this->_var['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
                                            <div class="option" data-value="<?php echo $this->_var['district']['region_id']; ?>" data-type="4" data-text="<?php echo $this->_var['district']['region_name']; ?>" ectype="ragionItem"><?php echo $this->_var['district']['region_name']; ?></div>
                                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                        </dd>
                                    </dl>
                                    <dl class="mod-select mod-select-small" ectype="smartdropdown" id="seller_soter" style="display:none;">
                                    	<dt><span class="txt" ectype="txt">请选择门店</span></dt>
                                        <dd ectype="layer"></dd>
                                    </dl>
                                    <span class="error" for="region"></span>
                                </div>
                            </div>
                            <div class="item">
                            	<div class="item_label"><?php echo $this->_var['lang']['time_shop']; ?>：</div>
                            	<div class="item_value">
                                	<div class="text_time"><input name="take_time" id="time_shop" type="text" class="text" data-val="<?php echo $this->_var['store_info']['take_time']; ?>" value="<?php echo $this->_var['store_info']['take_time']; ?>" readonly></div>
                                </div>
                            </div>
                            <div class="item">
                            	<div class="item_label"><?php echo $this->_var['lang']['phone_con']; ?>：</div>
                            	<div class="item_value"><input type="text" class="text text-2" data-val="<?php echo $this->_var['store_info']['store_mobile']; ?>" value="<?php echo $this->_var['store_info']['store_mobile']; ?>" name='store_mobile' placeholder="<?php echo $this->_var['lang']['store_take_mobile']; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                
                <?php if ($this->_var['is_exchange_goods'] != 1 || $this->_var['total']['real_goods_count'] != 0): ?>
                <div class="ck-step checkout">
                	<div class="ck-step-tit">
                    	<h3><?php echo $this->_var['lang']['payment_method']; ?></h3>
                    </div>
                    <div class="ck-step-cont">
                    	<div class="payment-warp">
                            <div class="payment-list" ectype="paymentType">
                                <?php if ($this->_var['is_presale_goods'] != 1 && ! $this->_var['store_id']): ?> 
                                    <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');$this->_foreach['payment'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payment']['total'] > 0):
    foreach ($_from AS $this->_var['payment']):
        $this->_foreach['payment']['iteration']++;
?>
									<?php if ($this->_foreach['payment']['total'] == 1): ?>
									<div class="p-radio-item payment-item item-selected" data-value='{"type":"<?php echo $this->_var['payment']['pay_code']; ?>","payid":"<?php echo $this->_var['payment']['pay_id']; ?>","allow":"<?php echo $this->_var['allow_use_surplus']; ?>"}'>
										<span>
                                            <input type="radio" checked isCod="<?php echo $this->_var['payment']['is_cod']; ?>" name="payment" class="ui-radio" value="<?php echo $this->_var['payment']['pay_id']; ?>" />
                                            <input type="radio" checked name="pay_code" class="ui-radio" value="<?php echo $this->_var['payment']['pay_code']; ?>" />
                                            <?php echo $this->_var['payment']['pay_name']; ?>
                                        </span>
                                        <b></b>
                                    </div>
									<?php else: ?>
									<div class="p-radio-item payment-item<?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id']): ?> item-selected<?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == 1): ?> hide<?php endif; ?><?php else: ?><?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == 1): ?> hide<?php endif; ?><?php endif; ?>" data-value='{"type":"<?php echo $this->_var['payment']['pay_code']; ?>","payid":"<?php echo $this->_var['payment']['pay_id']; ?>","allow":"<?php echo $this->_var['allow_use_surplus']; ?>"}'>
										<span>
                                            <input type="radio" <?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id']): ?>checked<?php endif; ?> isCod="<?php echo $this->_var['payment']['is_cod']; ?>" name="payment" class="ui-radio" value="<?php echo $this->_var['payment']['pay_id']; ?>" />
                                            <input type="radio" <?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id']): ?>checked<?php endif; ?> name="pay_code" class="ui-radio" value="<?php echo $this->_var['payment']['pay_code']; ?>" />
                                            <?php echo $this->_var['payment']['pay_name']; ?>
                                        </span>
                                        <b></b>
                                    </div>
									<?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                <?php else: ?>
                                    <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
										<?php if ($this->_var['payment']['pay_code'] == 'onlinepay' || $this->_var['payment']['pay_code'] == 'balance'): ?>
                                            <div class="p-radio-item payment-item<?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id']): ?> item-selected <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == 1): ?>hide<?php endif; ?><?php else: ?><?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == 1): ?>hide<?php endif; ?><?php endif; ?>" data-value='{"type":"<?php echo $this->_var['payment']['pay_code']; ?>","payid":"<?php echo $this->_var['payment']['pay_id']; ?>"}'>
                                                <span>
                                                    <input type="radio" <?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id']): ?>checked<?php endif; ?> isCod="<?php echo $this->_var['payment']['is_cod']; ?>" name="payment" class="ui-radio" value="<?php echo $this->_var['payment']['pay_id']; ?>" />
                                                    <input type="radio" <?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id']): ?>checked<?php endif; ?> name="pay_code" class="ui-radio" value="<?php echo $this->_var['payment']['pay_code']; ?>" />
                                                    <?php echo $this->_var['payment']['pay_name']; ?>
                                                </span>
                                                <b></b>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>   
                <?php endif; ?>
                
                
                
                <div class="ck-step">
                	<div class="ck-step-tit">
                    	<h3><?php echo $this->_var['lang']['goods_info']; ?></h3>
                        <?php if ($this->_var['order']['extension_code'] == ''): ?>
                        <a href="flow.php" class="extra-r"><?php echo $this->_var['lang']['back_cart']; ?></a>
                        <?php else: ?>
                        <a href="javascript:history.go(-1);" class="extra-r">返回上一页</a>
                        <?php endif; ?>
                    </div>
                    <div class="ck-step-cont">
                    	<div class="ck-goods-warp" id="goods_inventory">
                            <?php echo $this->fetch('library/flow_cart_goods.lbi'); ?>
                        </div>
                        <div class="ck-order-remark">
                            <input name="postscript" type="text" id="remarkText" maxlength="45" size="15" class="text" placeholder="<?php echo $this->_var['lang']['order_Remarks_desc']; ?>" autocomplete="off" onblur="if(this.value==''||this.value=='<?php echo $this->_var['lang']['order_Remarks_desc']; ?>'){this.value='<?php echo $this->_var['lang']['order_Remarks_desc']; ?>';this.style.color='#cccccc'}" onfocus="if(this.value=='<?php echo $this->_var['lang']['order_Remarks_desc']; ?>') {this.value='';};this.style.color='#666';">
                            <span class="prompt"><?php echo $this->_var['lang']['order_Remarks_desc_one']; ?></span>
                        </div>
                    </div>
                </div>    
                
                
                
				<?php if ($this->_var['config']['can_invoice'] && $this->_var['is_exchange_goods'] != 1): ?>
                <div class="ck-step">
                	<div class="ck-step-tit">
                    	<h3><?php echo $this->_var['lang']['Invoice_information']; ?></h3>
                        <div class="tips-new-white">
                            <b></b><span><i></i>开企业抬头发票须填写纳税人识别号，以免影响报销</span>
                        </div>
                    </div>
                    <div class="ck-step-cont" id='inv_content'>
                    	<div class="invoice-warp">
                            <div class="invoice-part">
                                <span>
                                	<em class="invoice_type"><?php echo $this->_var['lang']['Ordinary_invoice']; ?></em>
                                    <em class="inv_payee"><?php echo $this->_var['lang']['personal']; ?></em>
                                    <em class="inv_content"><?php echo $this->_var['inv_content']; ?></em>
                                </span>
                                <a href="javascript:void(0);" class="i-edit" ectype="invEdit" data-value='{"divid":"edit_invoice","url":"ajax_dialog.php?act=edit_invoice","title":"<?php echo $this->_var['lang']['Invoice_information']; ?>"}'><?php echo $this->_var['lang']['edit']; ?></a>
                                <input type="hidden" name="inv_payee" value="<?php echo $this->_var['lang']['personal']; ?>">
                                <input type="hidden" name="inv_content" value="<?php echo $this->_var['inv_content']; ?>">
								<input type="hidden" name="invoice_type" value="0">
								<input type="hidden" name="tax_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
				<?php endif; ?>
                
                
                
                <?php if ($_SESSION['flow_type'] != 5): ?>
                <div class="ck-step">
                	<div class="ck-step-tit">
                    	<h3><?php echo $this->_var['lang']['Other_information']; ?></h3>
                    </div>
                    <div class="ck-step-cont">
                    	<div class="other-warp">
                            <div class="other-list">
                                <?php if ($this->_var['allow_use_surplus'] && $this->_var['is_stages']): ?>
                                <div class="qt_item" id="qt_balance" <?php if ($this->_var['disable_surplus']): ?> style="display:none"<?php endif; ?>>
                                    <div class="item_label"><?php echo $this->_var['lang']['use_surplus']; ?>：</div>
                                    <div class="item_value">
                                        <input type="text" class="qt_text" name="surplus" id="ECS_SURPLUS" size="10" value="<?php echo $this->_var['order']['surplus']; ?>" data-yoursurplus="<?php echo empty($this->_var['your_surplus']) ? '0' : $this->_var['your_surplus']; ?>" onblur="changeSurplus(this.value)" />
                                        <input type="hidden" class="sur" value="<?php echo $this->_var['total']['goods_price_formated']; ?>" />
                                        <input type="hidden" class="shipping" value="<?php echo $this->_var['total']['shipping_fee_formated']; ?>" />
                                        <div class="sp"><span>当前<?php echo $this->_var['lang']['your_surplus']; ?></span><em>￥<?php echo empty($this->_var['your_surplus']) ? '0' : $this->_var['your_surplus']; ?></em></div>
                                        <div class="sp ftx-01" id="ECS_SURPLUS_NOTICE"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($this->_var['allow_use_integral']): ?>
                                <div class="qt_item" id="qt_integral">
                                    <div class="item_label"><?php echo $this->_var['lang']['use_integral']; ?>：</div>
                                    <div class="item_value">
                                        <input type="text" class="qt_text" name="integral" id="ECS_INTEGRAL" data-maxinteg="<?php echo $this->_var['order_max_integral']; ?>" onblur="changeIntegral(this.value)" value="<?php echo empty($this->_var['order']['integral']) ? '0' : $this->_var['order']['integral']; ?>" size="10"/>
                                        <div class="sp">
                                            <span><?php echo $this->_var['lang']['can_use_integral']; ?></span>
                                            <span><?php echo empty($this->_var['your_integral']) ? '0' : $this->_var['your_integral']; ?></span>
                                            <span>，<?php echo $this->_var['lang']['noworder_can_integral']; ?></span>
                                            <span><?php echo $this->_var['order_max_integral']; ?></span>
                                        </div>
                                        <div class="sp ftx-01" id="ECS_INTEGRAL_NOTICE"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($this->_var['open_pay_password']): ?>
                                <div class="qt_item" id="qt_onlinepay">
                                    <div class="item_label"><?php echo $this->_var['lang']['pay_password']; ?>：</div>
                                    <div class="item_value">
                                        <input type="password"   style="display:none" autocomplete="off" />
                                        <input type="password" class="qt_text" name="pay_pwd" size="20" value="" autocomplete="off" />
                                        <input name="pay_pwd_error" type="hidden" id="pwd_error" value="<?php echo $this->_var['pay_pwd_error']; ?>" autocomplete="off" />
                                        <div class="sp ftx-01" id="ECS_PAY_PAYPWD"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($this->_var['how_oos_list']): ?>
                                <div class="qt_item">
                                    <div class="item_label"><?php echo $this->_var['lang']['booking_process']; ?>：</div>
                                    <div class="item_value">
                                        <?php $_from = $this->_var['how_oos_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('how_oos_id', 'how_oos_name');if (count($_from)):
    foreach ($_from AS $this->_var['how_oos_id'] => $this->_var['how_oos_name']):
?>
                                        
                                        <div class="radio-item">
                                            <input type="radio" name="how_oos" class="ui-radio" value="<?php echo $this->_var['how_oos_id']; ?>" <?php if ($this->_var['order']['how_oos'] == $this->_var['how_oos_id']): ?>checked<?php endif; ?> id="checkbox_<?php echo $this->_var['how_oos_id']; ?>" onclick="changeOOS(this)" autocomplete="off" />
                                            <label for="checkbox_<?php echo $this->_var['how_oos_id']; ?>" class="ui-radio-label"><?php echo $this->_var['how_oos_name']; ?></label>
                                        </div>
                                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>    
                <?php endif; ?>
                
                
                
                <?php if ($this->_var['value_card_list'] && $this->_var['is_value_cart'] != 0 || $this->_var['user_coupons'] || $this->_var['coupons_list'] || $this->_var['bonus_list'] || $this->_var['no_bonuslist']): ?>
                <div class="ck-step ck-step-other">
                	<div class="ck-step-tit ck-toggle ck-toggle-off" ectype="ck-toggle">
                    	<h3><?php echo $this->_var['lang']['preferential']; ?>/<?php echo $this->_var['lang']['value_card']; ?>/<?php echo $this->_var['lang']['bonus']; ?></h3>
                        <i class="iconfont icon-down"></i>
                        <?php if ($this->_var['user_coupons'] || $this->_var['value_card_list'] && $this->_var['is_value_cart'] == 1 || $this->_var['bonus_list']): ?><span class="tag">有可用</span><?php endif; ?>
                    </div>
                    <div class="ck-step-cont" style="display:none;">
                    	<div class="order-virtual-tabs">
                        	<ul>
                            	<?php if ($this->_var['user_coupons'] || $this->_var['coupons_list']): ?><li class="curr"><span><?php echo $this->_var['lang']['preferential']; ?></span><?php if ($this->_var['user_coupons']): ?><b></b><?php endif; ?></li><?php endif; ?>
                                <?php if ($this->_var['allow_use_value_card'] && $this->_var['is_value_cart'] == 1): ?><li><span><?php echo $this->_var['lang']['value_card']; ?></span><?php if ($this->_var['value_card_list']): ?><b></b><?php endif; ?></li><?php endif; ?>
                                <?php if ($this->_var['bonus_list'] || $this->_var['no_bonuslist']): ?><li><span><?php echo $this->_var['lang']['bonus']; ?></span><?php if ($this->_var['bonus_list']): ?><b></b><?php endif; ?></li><?php endif; ?>
                            </ul>
                        </div>
                        
                        <div class="toggle-panel-main">
                            <?php if ($this->_var['user_coupons'] || $this->_var['coupons_list']): ?>
                            <div class="toggle-panl-warp panl-coupon" ectype='order_coupoms_list'>
                                <?php echo $this->fetch('library/order_coupoms_list.lbi'); ?>
                            </div>
                            <?php endif; ?>
                            <?php if ($this->_var['allow_use_value_card'] && $this->_var['is_value_cart'] == 1): ?>
                            <div class="toggle-panl-warp panl-stored">
                            	<div class="panl-warp">
                                    <?php $_from = $this->_var['value_card_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value_card');if (count($_from)):
    foreach ($_from AS $this->_var['value_card']):
?>
                                    <div class="panl-item" ectype="panlItem" data-ucid="<?php echo $this->_var['value_card']['vc_id']; ?>"data-type="value_card">
                                    	<p class="tit"><?php echo $this->_var['value_card']['name']; ?></p>
                                        <strong><?php echo $this->_var['value_card']['card_money_formated']; ?></strong>
                                        <span class="p-total"><?php echo $this->_var['value_card']['card_limit']; ?></span>
                                        <b></b>
                                    </div>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    <input name="value_card_psd" id="value_card_psd" type="text" class="qt_text2 order_vc_psd hide" size="15" value="" autocomplete="off" />
                                    <input name="validate_value_card" type="button" class="hide" id="bnt_bonus_sn" value="<?php echo $this->_var['lang']['bind_value_card']; ?>" onclick="validateVcard($('.order_vc_psd').val())" autocomplete="off" />
                                    <div class="panl-item panl-item-new">
                                    	<a href="user.php?act=value_card" target="_blank" class="add-new-stored">
                                        	<i class="iconfont icon-jia"></i>
                                            <em>去添加储值卡</em>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($this->_var['bonus_list'] || $this->_var['no_bonuslist']): ?>
                            <div class="toggle-panl-warp panl-redBag">
                                <?php if ($this->_var['bonus_list']): ?>
                            	<div class="panl-top">
                                	<div class="panl-items">
                                    <?php $_from = $this->_var['bonus_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bonus');$this->_foreach['bonus_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bonus_list']['total'] > 0):
    foreach ($_from AS $this->_var['bonus']):
        $this->_foreach['bonus_list']['iteration']++;
?>
                                	<div class="panl-item<?php if ($this->_foreach['bonus_list']['iteration'] % 4 == 0): ?> panl-item-last<?php endif; ?>" ectype="panlItem" data-ucid="<?php echo $this->_var['bonus']['bonus_id']; ?>" data-type="bonus" title="<?php echo $this->_var['lang']['full']; ?>￥<?php echo $this->_var['bonus']['min_goods_amount']; ?><?php echo $this->_var['lang']['keyong']; ?>">
                                        <strong><?php echo $this->_var['bonus']['bonus_money_formated']; ?></strong>
                                        <p><?php echo $this->_var['lang']['bonus_card_number']; ?>：<?php echo $this->_var['bonus']['type_name']; ?></p>
                                        <p><?php echo $this->_var['lang']['overdue_time']; ?>：<?php echo $this->_var['bonus']['use_end_date']; ?></p>
                                        <b></b>
                                    </div>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ($this->_var['no_bonuslist']): ?>
                                <div class="panl-bot">
                                	<div class="panl-items">
                                    <?php $_from = $this->_var['no_bonuslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bonus');$this->_foreach['no_bonuslist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no_bonuslist']['total'] > 0):
    foreach ($_from AS $this->_var['bonus']):
        $this->_foreach['no_bonuslist']['iteration']++;
?>
                                    <div class="panl-item panl-item-disabled<?php if ($this->_foreach['no_bonuslist']['iteration'] % 4 == 0): ?> panl-item-last<?php endif; ?>" title="满<?php echo $this->_var['bonus']['min_goods_amount_old']; ?>￥<?php echo $this->_var['lang']['keyong']; ?>">
                                         <strong><?php echo $this->_var['bonus']['type_money']; ?></strong>
                                        <p><?php echo $this->_var['lang']['bonus_card_number']; ?>：<?php echo $this->_var['bonus']['type_name']; ?></p>
                                        <p><?php echo $this->_var['lang']['overdue_time']; ?>：<?php echo $this->_var['bonus']['use_enddate']; ?></p>
                                        <b></b>
                                    </div>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="uc_id" id="uc_id" value="0" autocomplete="off">
                        <input type="hidden" name="not_freightfree" id="not_freightfree" value="0" autocomplete="off">
                        
                        <input type="hidden" name="bonus" id="bonus_id" value="0" autocomplete="off">
                        <input type="hidden" name="vc_id" id="ECS_VALUE_CARD" value="0" autocomplete="off">
                    </div>
                </div>    
                <?php endif; ?>
                
            </div>
            <div id="ECS_ORDERTOTAL">
			<?php echo $this->fetch('library/order_total.lbi'); ?>
            </div>
            
            <input type="hidden" name="user_id" value="<?php echo $this->_var['user_id']; ?>" autocomplete="off" />
            <input type="hidden" name="done_cart_value" value="<?php echo $this->_var['cart_value']; ?>" autocomplete="off" />
            <input type="hidden" name="step" value="done" autocomplete="off" />
            <input type="hidden" name="is_address" value="0" autocomplete="off" />
        </div>
        </form>
    </div>
    <?php endif; ?>
    
    <?php if ($this->_var['step'] == "done" || $this->_var['step'] == "order_reload"): ?>
    <div class="container">
        <div class="w w1200">
            <?php if ($this->_var['is_onlinepay']): ?>
            
            <div class="payOrder-warp" id="pay_main">
                <div class="payOrder-desc">
                    <div class="pay-top">
                        <h3><?php if ($this->_var['order']['order_amount'] > 0): ?>订单提交成功，去付款咯！<?php else: ?>订单提交成功！<?php endif; ?></h3>
                        <div class="pay-total">
                            <span>应付<?php echo $this->_var['stages_info']['stages_qishu']; ?>总额：</span>
                            <div class="pay-price">￥<?php echo $this->_var['order']['order_amount']; ?></div>
                        </div>
                    </div>
                    <div class="pay-txt">
                        <p><?php echo $this->_var['lang']['order_number']; ?>：<em id="nku"><?php echo $this->_var['order']['order_sn']; ?></em></p>
                        <p><?php echo $this->_var['lang']['Select_payment']; ?>：<span id="paymode"><?php echo $this->_var['order']['pay_name']; ?></span></p>
                        <?php if ($this->_var['stores_info']): ?>
                        <p><?php echo $this->_var['lang']['store_name']; ?>：<span><?php echo $this->_var['stores_info']['stores_name']; ?></span></p>
                        <?php else: ?>
                        	<?php if ($this->_var['child_order'] == 0): ?>
                            <?php if ($this->_var['order']['shipping_name'] && $this->_var['order']['shipping_isarr'] == 0): ?>
                            <p>配送方式: <span id="express"><?php echo $this->_var['order']['shipping_name']; ?></span></p>
                            <?php endif; ?>
                            <?php else: ?>
                            <p><span class="txt"><?php echo $this->_var['lang']['checkout_success_six']; ?><em><?php echo $this->_var['child_order']; ?></em><?php echo $this->_var['lang']['checkout_success_three']; ?>：</span></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($this->_var['child_order'] == 0): ?>
                    <div class="o-list">
                        <div class="o-list-info">
                            <span id="shdz"><?php echo $this->_var['lang']['Send_to']; ?>：<?php echo $this->_var['order']['region']; ?>&nbsp;&nbsp;<?php echo $this->_var['order']['address']; ?></span>
                            <span id="shr"><?php echo $this->_var['lang']['Consignee']; ?>：<?php echo $this->_var['order']['consignee']; ?></span>
                            <span id="mobile"><?php echo $this->_var['order']['mobile']; ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <a href="flow.php?step=pdf&order=<?php echo $this->_var['order']['order_id']; ?>" target="_blank" class="orderPrint ftx-05"><?php echo $this->_var['lang']['orders_print']; ?></a>&nbsp;&nbsp;
                    <a href="index.php" target="_blank" class="orderPrint ftx-05"><?php echo $this->_var['lang']['pay_qt']; ?></a>
                </div>
                
                <?php if ($this->_var['child_order'] != 0): ?>
                <div class="w1200" style="height:10px; overflow:hidden;">&nbsp;</div>
                <div class="w1200" style="background:#FFF;">
                    <div class="shopend-info-many mt10" style="text-align:center; padding-top:20px;">
                        <div class="shopend-info-items">
                        <?php $_from = $this->_var['child_order_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c_order');if (count($_from)):
    foreach ($_from AS $this->_var['c_order']):
?>
                        <div class="shopend-info-item">
                            <p><?php echo $this->_var['lang']['order_number']; ?>：<em class="nku" id="nku"><?php echo $this->_var['c_order']['order_sn']; ?></em></p>
                            
                            <?php if ($this->_var['c_order']['order_amount'] > 0): ?>
                            <p>应付金额：<em><?php echo $this->_var['c_order']['amount_formated']; ?></em></p>
                            <?php endif; ?>
                            
                            <?php if ($this->_var['c_order']['pay_total'] > 0): ?>
                            <p>已付金额：<em><?php echo $this->_var['c_order']['total_formated']; ?></em></p>
                            <?php endif; ?>
                        
                            <?php if (! $this->_var['is_group_buy']): ?>
                            <p><?php echo $this->_var['lang']['shipping_method']; ?>：<em><?php echo $this->_var['c_order']['shipping_name']; ?></em>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_var['lang']['freight']; ?>：<em><?php echo $this->_var['c_order']['shipping_fee_formated']; ?></em></p>
                            <?php endif; ?>
                            <?php if ($this->_var['stores_info']): ?>
                            <p><?php echo $this->_var['lang']['store_name']; ?>：<em><?php echo $this->_var['stores_info']['stores_name']; ?></em></p>
                            <?php else: ?>
                            <p>收货人：<span id="username"><?php echo $this->_var['order']['consignee']; ?></span><span id="tel" class="ml20"><?php echo $this->_var['order']['mobile']; ?></span></p>
                            <p>寄送至：<span id="address"><?php echo $this->_var['address_info']; ?>&nbsp;<?php echo $this->_var['order']['address']; ?></span></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div>
                    </div>
                </div>    
                <?php endif; ?>
                
                <?php if ($this->_var['is_onlinepay']): ?>
                <div class="payOrder-mode">
                    <?php if ($this->_var['stages_info'] && $this->_var['stages_info']['stages_qishu'] && $this->_var['is_chunsejinrong']): ?>
                        <div class="payOrder-list">
                            <div class="p-mode-list">
                                <div class="p-mode-item chunsejinrong">
                                    <a href="flow.php?step=done&act=chunsejinrong&order_sn=<?php echo $this->_var['order']['order_sn']; ?>" id="chunsejinrong" order_sn="<?php echo $this->_var['order']['order_sn']; ?>" style="height: 36px;line-height: 36px;float: left;" flag="chunsejinrong" >1111<?php echo $this->_var['lang']['ious_pay']; ?></a>
                                </div>
                                <div class="bt-desc">
                                	<p>
                                        <span class="mr10"><?php echo $this->_var['lang']['Available_Credit']; ?>：<?php echo $this->_var['stages_info']['baitiao']; ?>元</span>
                                        <span>下次还款日：<?php echo $this->_var['stages_info']['repay_date']; ?></span>
                                    </p>
                                	<p class="qishu"><?php echo $this->_var['stages_info']['stages_qishu']; ?><?php echo $this->_var['lang']['qi']; ?> | <?php echo $this->_var['stages_info']['stages_one_price']; ?><?php echo $this->_var['lang']['yuan']; ?>/<?php echo $this->_var['lang']['qi']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="payOrder-list">
                            <div class="p-mode-tit">
                                <h3>在线支付</h3>
                            </div>
                            <div class="p-mode-list">
                                <?php if ($this->_var['is_presale_goods']): ?>
                                    <?php $_from = $this->_var['pay_online_button']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['vo']):
?>
                                    <?php if ($this->_var['key'] != 'chunsejinrong'): ?>
                                        <div class="p-mode-item <?php echo $this->_var['key']; ?>" order_sn="<?php echo $this->_var['order']['order_sn']; ?>" flag="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['vo']; ?></div>
                                    <?php else: ?>
                                        <?php if ($this->_var['seller_grade'] == 1): ?>
                                        <div class="p-mode-item <?php echo $this->_var['key']; ?>" order_sn="<?php echo $this->_var['order']['order_sn']; ?>" flag="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['vo']; ?></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                <?php else: ?>
                                    <?php $_from = $this->_var['pay_online_button']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['vo']):
?>
                                    <?php if ($this->_var['key'] == 'chunsejinrong'): ?>
                                        <?php if ($this->_var['seller_grade'] == 1 && $this->_var['stages_info'] && $this->_var['stages_info']['stages_qishu'] && $this->_var['is_chunsejinrong']): ?>
                                        <div class="p-mode-item <?php echo $this->_var['key']; ?>">
                                        	<a href="flow.php?step=done&act=chunsejinrong&order_sn=<?php echo $this->_var['order']['order_sn']; ?>" id="chunsejinrong" order_sn="<?php echo $this->_var['order']['order_sn']; ?>" style="height: 36px;line-height: 36px;float: left;" flag="chunsejinrong" ><?php echo $this->_var['lang']['ious_pay']; ?></a>
                                        </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="p-mode-item <?php echo $this->_var['key']; ?>" order_sn="<?php echo $this->_var['order']['order_sn']; ?>" flag="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['vo']; ?></div>
                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php else: ?> 
                    <div class="single-btn">
                        <?php if ($this->_var['pay_online']): ?>
                        
                        <?php echo $this->_var['pay_online']; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php else: ?>
            
            <div class="shopend-warp">
                
                <?php if ($this->_var['child_order'] != 0): ?>
                <div class="shopend-info-many">
                    <div class="shopend-info">
                        <div class="s-i-left"><i class="ico-success"></i></div>
                        <div class="s-i-right">
                            <h3>
                            <?php if ($this->_var['order']['pay_code'] == 'cod'): ?>
                                您选择的是货到付款，请联系客服
                            <?php elseif ($this->_var['order']['pay_code'] == 'bank'): ?>
                                您选择的是线下转账请转账后联系客服
                            <?php else: ?>
                            	<?php if ($this->_var['order']['pay_code'] == 'balance'): ?>
                                <?php echo $this->_var['lang']['payment_Success']; ?>
                                <?php else: ?>
                                您选择在线支付，请查看订单继续完成支付订单    
                                <?php endif; ?>
                            <?php endif; ?>
                            </h3>
                            <span class="txt"><?php echo $this->_var['lang']['checkout_success_six']; ?><em><?php echo $this->_var['child_order']; ?></em><?php echo $this->_var['lang']['checkout_success_three']; ?>：</span>
                        </div>
                    </div>
                    <div class="shopend-info-items">
                    <?php $_from = $this->_var['child_order_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c_order');if (count($_from)):
    foreach ($_from AS $this->_var['c_order']):
?>
                    <div class="shopend-info-item">
                        <p><?php echo $this->_var['lang']['order_number']; ?>：<em class="nku" id="nku"><?php echo $this->_var['c_order']['order_sn']; ?></em></p>
                        
                        <?php if ($this->_var['c_order']['order_amount'] > 0): ?>
                        <p>应付金额：<em><?php echo $this->_var['c_order']['amount_formated']; ?></em></p>
                        <?php endif; ?>
                        
                        <?php if ($this->_var['c_order']['pay_total'] > 0): ?>
                        <p>已付金额：<em><?php echo $this->_var['c_order']['total_formated']; ?></em></p>
                        <?php endif; ?>
                        
                        <?php if (! $this->_var['is_group_buy']): ?>
                        <p><?php echo $this->_var['lang']['shipping_method']; ?>：<em><?php echo $this->_var['c_order']['shipping_name']; ?></em>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_var['lang']['freight']; ?>：<em><?php echo $this->_var['c_order']['shipping_fee_formated']; ?></em></p>
                        <?php endif; ?>
                        <?php if ($this->_var['stores_info']): ?>
                        <p><?php echo $this->_var['lang']['store_name']; ?>：<em><?php echo $this->_var['stores_info']['stores_name']; ?></em></p>
                        <?php else: ?>
                        <p>收货人：<span id="username"><?php echo $this->_var['order']['consignee']; ?></span><span id="tel" class="ml20"><?php echo $this->_var['order']['mobile']; ?></span></p>
                        <p>寄送至：<span id="address"><?php echo $this->_var['address_info']; ?>&nbsp;<?php echo $this->_var['order']['address']; ?></span></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                    <?php if ($this->_var['order']['pay_code'] == 'bank'): ?>
                    <p class="yh-zz"><?php echo $this->_var['order']['pay_desc']; ?></p>
                    <?php endif; ?>
                    <div class="clear"></div>
                    <div class="s-i-btn">
                        <a href="<?php if ($this->_var['is_zc_order']): ?>user.php?act=crowdfunding<?php else: ?>user.php?act=order_list<?php endif; ?>" class="btn sc-redBg-btn">查看订单</a>
                        <a href="index.php" class="btn sc-red-btn">返回首页</a>
                    </div>
                </div>
                <?php else: ?>
                <div class="shopend-info">
                    <div class="s-i-left"><i class="ico-success"></i></div>
                    <div class="s-i-right">
                    	<h3>
                        <?php if ($this->_var['order']['pay_code'] == 'cod'): ?>
                            您选择的是货到付款，请联系客服
                        <?php elseif ($this->_var['order']['pay_code'] == 'bank'): ?>
                            您选择的是线下转账请转账后联系客服
                        <?php else: ?>
                            <?php if ($this->_var['order']['pay_code'] == 'balance' || $this->_var['order']['order_amount'] == 0): ?>
                            <?php echo $this->_var['lang']['payment_Success']; ?>
                            <?php else: ?>
                            您选择在线支付，请查看订单继续完成支付订单    
                            <?php endif; ?>
                        <?php endif; ?>
                        </h3>
                        <div class="s-i-tit">
                            <p><?php echo $this->_var['lang']['order_number']; ?>：<em id="nku"><?php echo $this->_var['order']['order_sn']; ?></em></p>
                            <?php if ($this->_var['stores_info']): ?>
                            <p><?php echo $this->_var['lang']['shipping_method']; ?>：<em>门店自提</em></p>
                            <p><?php echo $this->_var['lang']['store_name']; ?>：<em><?php echo $this->_var['stores_info']['stores_name']; ?></em></p>
                            <?php else: ?>
                            <?php if (! $this->_var['is_group_buy']): ?>
                            <p><?php echo $this->_var['lang']['shipping_method']; ?>：<em><?php echo $this->_var['order']['shipping_name']; ?></em></p>
                            <p><?php echo $this->_var['lang']['freight']; ?>：<em><?php echo $this->_var['order']['format_shipping_fee']; ?></em></p>
                            <?php endif; ?>
                            <p><?php echo $this->_var['lang']['Total_amount_payable']; ?>：<em><?php echo $this->_var['order']['format_order_amount']; ?></em></p>
                            <p>收货人：<span id="username"><?php echo $this->_var['order']['consignee']; ?></span><span id="tel" class="ml20"><?php echo $this->_var['order']['mobile']; ?></span></p>
                            <p>寄送至： <span id="address"><?php echo $this->_var['address_info']; ?>&nbsp;<?php echo $this->_var['order']['address']; ?></span></p>
                            <?php endif; ?>
                        </div>
                        <?php if ($this->_var['order']['pay_code'] == 'bank'): ?>
                        <p class="yh-zz"><?php echo $this->_var['order']['pay_desc']; ?></p>
                        <?php endif; ?>
                        <div class="s-i-btn">
                            <?php if ($this->_var['is_zc_order']): ?>
                            <a href="user.php?act=crowdfunding" class="btn sc-redBg-btn">查看订单</a>
                            <?php else: ?>
                            <a href="user.php?act=order_list" class="btn sc-redBg-btn">查看订单</a>
                            <?php endif; ?>
                            <a href="index.php" class="btn sc-red-btn">返回首页</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($this->_var['goods_buy_list']): ?>
            <div class="p-panel-main c-history">
                <div class="ftit ftit-delr"><h3>继续剁手</h3></div>
                <div class="gl-list clearfix">
                    <ul class="clearfix">
                        <?php $_from = $this->_var['goods_buy_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goodsbuy'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goodsbuy']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goodsbuy']['iteration']++;
?>
                        <?php if ($this->_foreach['goodsbuy']['iteration'] < 7): ?>
						<?php if ($this->_var['goods']['goods_id']): ?>
                        <li class="opacity_img">
                            <div class="p-img"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="190" height="190"></a></div>
                            <div class="p-price">
                                <?php if ($this->_var['goods']['promote_price'] == ''): ?>
                                    <?php echo $this->_var['goods']['shop_price']; ?>
                                <?php else: ?>
                                    <?php echo $this->_var['goods']['promote_price']; ?>
                                <?php endif; ?>
                            </div>
                            <div class="p-name"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a></div>
                            <div class="p-num">已售<em><?php echo $this->_var['goods']['sales_volume']; ?></em>件</div>
                        </li>
						<?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="pay_Dialog" class="hide">
    	<div class="pat"><?php echo $this->_var['lang']['pat']; ?></div>
        <div class="paydia-warp">
        	<i></i>
            <div class="con">
            	<div class="con-warp con-success">
                    <h3><?php echo $this->_var['lang']['pay_dialog_success']; ?></h3>
                    <a href="user.php?act=order_list" class="ftx-05"><?php echo $this->_var['lang']['order_detail']; ?>></a>
                </div>
                <div class="con-warp con-fail">
                	<h3><?php echo $this->_var['lang']['pay_dialog_fail']; ?></h3>
                	<a href="article.php?id=17" class="ftx-05"><?php echo $this->_var['lang']['pay_problem']; ?>></a>
                    <a href="index.php" class="ftx-05"><?php echo $this->_var['lang']['pay_qt']; ?>></a>
                </div>
            </div>
        </div>
    </div>
	<?php if ($this->_var['ajax_send_mail']): ?>
	<script type="text/javascript">
		var send_time = '<?php echo $this->_var['send_time']; ?>';
		var order_id = '<?php echo $this->_var['order_id']; ?>';
		Ajax.call('ajax_dialog.php?act=ajax_send_mail', 'send_time=' + send_time + '&order_id=' + order_id, '', 'POST','JSON');
	</script>
	<?php endif; ?>
    <?php endif; ?>
    
    
    <?php if ($this->_var['pay_success']): ?>
    <div class="shopend-warp">
        
        <?php if ($this->_var['child_order'] != 0): ?>
        <div class="shopend-info-many">
        	<div class="shopend-info">
                <div class="s-i-left"><i class="ico-success"></i></div>
                <div class="s-i-right">
                    <h3><?php echo $this->_var['lang']['payment_Success']; ?></h3>
                    <span class="txt"><?php echo $this->_var['lang']['checkout_success_six']; ?><em><?php echo $this->_var['child_order']; ?></em><?php echo $this->_var['lang']['checkout_success_three']; ?>：</span>
                </div>
            </div>
            <div class="shopend-info-items">
            <?php $_from = $this->_var['child_order_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c_order');if (count($_from)):
    foreach ($_from AS $this->_var['c_order']):
?>
            <div class="shopend-info-item">
                <p><?php echo $this->_var['lang']['order_number']; ?>：<em class="nku" id="nku"><?php echo $this->_var['c_order']['order_sn']; ?></em></p>
                <p><?php echo $this->_var['lang']['Total_amount_payable']; ?>：<em><?php echo $this->_var['c_order']['order_amount']; ?></em></p>
                <?php if (! $this->_var['is_group_buy']): ?>
                <p><?php echo $this->_var['lang']['shipping_method']; ?>：<em><?php echo $this->_var['c_order']['shipping_name']; ?></em>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_var['lang']['freight']; ?>：<em>￥<?php echo $this->_var['c_order']['shipping_fee']; ?></em></p>
                <?php endif; ?>
                <?php if ($this->_var['stores_info']): ?>
                <p><?php echo $this->_var['lang']['store_name']; ?>：<em><?php echo $this->_var['stores_info']['stores_name']; ?></em></p>
                <?php else: ?>
                <p>收货人：<span id="username"><?php echo $this->_var['order']['consignee']; ?></span><span id="tel" class="ml20"><?php echo $this->_var['order']['mobile']; ?></span></p>
                <p>寄送至：<span id="address"><?php echo $this->_var['address_info']; ?>&nbsp;<?php echo $this->_var['order']['address']; ?></span></p>
                <?php endif; ?>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <div class="clear"></div>
            <div class="s-i-btn">
                <?php if ($this->_var['is_zc_order']): ?>
                <a href="user.php?act=crowdfunding" class="btn sc-redBg-btn">查看订单</a>
                <?php else: ?>
                <a href="user.php?act=order_list" class="btn sc-redBg-btn">查看订单</a>
                <?php endif; ?>
                <a href="index.php" class="btn sc-red-btn">返回首页</a>
            </div>
        </div>
        <?php else: ?>
        <div class="shopend-info">
            <div class="s-i-left"><i class="ico-success"></i></div>
            <div class="s-i-right">
                <h3><?php echo $this->_var['lang']['payment_Success']; ?></h3>
                <div class="s-i-tit">
                    <p><?php echo $this->_var['lang']['order_number']; ?>：<em id="nku"><?php echo $this->_var['order']['order_sn']; ?></em></p>
                    <p><?php echo $this->_var['lang']['Total_amount_payable']; ?>：<em><?php echo $this->_var['order']['order_amount']; ?></em></p>
                    <?php if ($this->_var['stores_info']): ?>
                    <p><?php echo $this->_var['lang']['shipping_method']; ?>：<em>门店自提</em></p>
                    <p><?php echo $this->_var['lang']['store_name']; ?>：<em><?php echo $this->_var['stores_info']['stores_name']; ?></em></p>
                    <?php else: ?>
                    <?php if (! $this->_var['is_group_buy']): ?>
                    <p><?php echo $this->_var['lang']['shipping_method']; ?>：<em><?php echo $this->_var['order']['shipping_name']; ?></em></p>
                    <p><?php echo $this->_var['lang']['freight']; ?>：<em>￥<?php echo $this->_var['order']['shipping_fee']; ?></em></p>
                    <?php endif; ?>
                    <p>收货人：<span id="username"><?php echo $this->_var['order']['consignee']; ?></span><span id="tel" class="ml20"><?php echo $this->_var['order']['mobile']; ?></span></p>
                    <p>寄送至： <span id="address"><?php echo $this->_var['address_info']; ?>&nbsp;<?php echo $this->_var['order']['address']; ?></span></p>
                    <?php endif; ?>
                </div>
                <div class="s-i-btn">
                    <?php if ($this->_var['is_zc_order']): ?>
                    <a href="user.php?act=crowdfunding" class="btn sc-redBg-btn">查看订单</a>
                    <?php else: ?>
                    <a href="user.php?act=order_list" class="btn sc-redBg-btn">查看订单</a>
                    <?php endif; ?>
                    <a href="index.php" class="btn sc-red-btn">返回首页</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($this->_var['goods_buy_list']): ?>
        <div class="p-panel-main c-history">
            <div class="ftit ftit-delr"><h3>继续剁手</h3></div>
            <div class="gl-list clearfix">
                <ul class="clearfix">
                    <?php $_from = $this->_var['goods_buy_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goodsbuy'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goodsbuy']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goodsbuy']['iteration']++;
?>
                    <?php if ($this->_foreach['goodsbuy']['iteration'] < 7): ?>
                    <li class="opacity_img">
                        <div class="p-img"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="190" height="190"></a></div>
                        <div class="p-price">
                            <?php if ($this->_var['goods']['promote_price'] == ''): ?>
                                <?php echo $this->_var['goods']['shop_price']; ?>
                            <?php else: ?>
                                <?php echo $this->_var['goods']['promote_price']; ?>
                            <?php endif; ?>
                        </div>
                        <div class="p-name"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a></div>
                        <div class="p-num">已售<em><?php echo $this->_var['goods']['sales_volume']; ?></em>件</div>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    
    <?php echo $this->fetch('library/cart_html.lbi'); ?>
    
    <?php echo $this->fetch('library/page_footer.lbi'); ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'jquery.SuperSlide.2.1.1.js,common.js,shopping_flow.js,warehouse.js,jquery.nyroModal.js,perfect-scrollbar/perfect-scrollbar.min.js,lib_ecmobanFunc.js,jquery.validation.min.js')); ?>
    <?php if ($this->_var['store_id']): ?><?php echo $this->smarty_insert_scripts(array('files'=>'calendar.php')); ?><?php endif; ?>
	
	<script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/dsc-common.js"></script>
    <script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/jquery.purebox.js"></script>
    <script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/region.js"></script>
    
	<?php if ($this->_var['step'] == "cart"): ?>
    <?php if ($this->_var['goods_list']): ?><script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/checkAll.js"></script><?php endif; ?>
    <script type="text/javascript">
    	function changenum(rec_id, diff, warehouse_id, area_id, favourable_id){
            var cValue = $("#cart_value").val();
            var goods_number = Number($('#goods_number_' + rec_id).val()) + Number(diff);    
            if(goods_number < 1){
				pbDialog(json_languages.Purchase_restrictions,"",0)
            }else{
                change_goods_number(rec_id,goods_number, warehouse_id, area_id, cValue, favourable_id);
            }
        }
		
        function change_goods_number(rec_id, goods_number, warehouse_id, area_id, cValue, favourable_id){
            if(cValue != "" || cValue == 'undefined'){
               var cValue = $("#cart_value").val(); 
            }
            if(goods_number == 0){
                //pbDialog("数量不能为0","",0);
                goods_number = 1;
            }

            var items = $("#checkItem_" +rec_id).parents(".item-single");
            var input = items.find("*[ectype='ckGoods']");
            var str ='';
            var arr = [];
            input.each(function(){
                if($(this).prop('checked')== true){
                    var val = $(this).val();
                    str += val + ',';
                    arr.push(val);
                }
            });

            str = str.substring(str.length-1,0);

            if(str == ""){
                pbDialog("请勾选中商品在修改商品数量","",0);
                return false;
            }else{
                if(arr.indexOf(String(rec_id)) == -1){
                    pbDialog("请勾选中商品在修改商品数量","",0);
                    return false;
                }

                if(items.attr("ectype") == "promoItem"){
                    var promoStr = "";
                    input.each(function(){
                        var val = $(this).val();
                        promoStr += val + ',';
                    })

                    promoStr = promoStr.substring(promoStr.length-1,0);
                }
            }
            
            Ajax.call('flow.php?step=ajax_update_cart', 'rec_id=' + rec_id + '&sel_id=' + str + '&pro_sel_id=' + promoStr + '&sel_flag=' + 'cart_sel_flag' +'&goods_number=' + goods_number +'&cValue=' + cValue +'&warehouse_id=' + warehouse_id +'&area_id=' + area_id +'&favourable_id=' + favourable_id, change_goods_number_response, 'POST','JSON');                
        }
		
        function change_goods_number_response(result)
        {
            var rec_id = result.rec_id;           
            if(result.error == 0){
                $('#goods_number_' +rec_id).val(result.goods_number);//更新数量
                $('#goods_subtotal_' +rec_id).html(result.goods_subtotal);//更新小计
				
				if(result.dis_amount > 0){
					$('#discount_amount_' +rec_id).parents('.cuttip').removeClass("hide");
				}else{
					$('#discount_amount_' +rec_id).parents('.cuttip').addClass("hide");
				}
				
				$('#discount_amount_' +rec_id).html(result.discount_amount);//商品优惠价格
				
                if(result.goods_number == 1){
                    $('#goods_number_' +rec_id).parents('.amount-warp').find('.btn-reduce').addClass("btn-disabled");
                }else{
                    $('#goods_number_' +rec_id).parents('.amount-warp').find('.btn-reduce').removeClass("btn-disabled");
                }
                if(result.goods_number <= 0){
                    $('#tr_goods_' +rec_id).style.display = 'none'; //数量为零则隐藏所在行
                    $('#tr_goods_' +rec_id).innerHTML = '';
                }
                $('#total_desc').html(result.flow_info);//更新合计
                if ($('ECS_CARTINFO')){
                    $('#ECS_CARTINFO').html(result.cart_info); //更新购物车数量
                }
        
                if(result.group.length > 0){
                    for(var i=0; i<result.group.length; i++){
                        $("#" + result.group[i].rec_group).html(result.group[i].rec_group_number);//配件商品数量
                        $("#" + result.group[i].rec_group_talId).html(result.group[i].rec_group_subtotal);//配件商品金额
                    }
                }
                
                $("#goods_price_" + rec_id).html(result.goods_price);
                $("*[ectype='save_total']").html(result.save_total_amount); //优惠节省总金额
                $("*[ectype='cartNum']").html(result.subtotal_number); //商品总数
                
                // 如果是优惠活动内的商品，更新优惠活动局部 qin
                if (result.act_id){
                    $("#product_promo_" + result.ru_id + "_" + result.act_id).html(result.favourable_box_content);
                }
            }else if(result.message != ''){
				//更新数量
                $('#goods_number_' +rec_id).val(result.cart_Num);
				pbDialog(result.message," ",0,"",90,10);
            }                
        }
		<?php if ($this->_var['goods_list']): ?>
		//购物车底边悬浮栏
		tfootScroll();
		<?php endif; ?>
		//超值礼包
		$(".package_goods ul").perfectScrollbar("destroy");
		$(".package_goods ul").perfectScrollbar();
    </script>
    
	<?php elseif ($this->_var['step'] == "checkout"): ?>
	<script type="text/javascript">
		$(function(){
			/* 门店订单显示信息 start*/
			if($("*[ectype='storeWarp']").length > 0){
				$("#consignee_list,.d-address").addClass("hide");
				$("input[name='is_address']").val(1);
			}else{
				$("#selProvinces").val(0);
				$("#store_id").val(0);
			}
			/* 门店订单显示信息 end*/
			
			/* 优惠券/储值卡/红包切换 */
			$(".ck-step-cont").slide({titCell:".order-virtual-tabs li",mainCell:".toggle-panel-main",titOnClassName:"curr",trigger:"click"});
			
			//点击查看图片
			$('.nyroModal').nyroModal();
			
			//购物车底边悬浮栏
			tfootScroll();
			
			<?php if ($this->_var['seller_store'] || $this->_var['store_seller'] == 'store_seller'): ?>
			$.levelLink(1);
			<?php endif; ?>
		});
			
		//门店时间选择
		<?php if ($this->_var['store_id']): ?>
		var opts1 = {
			'targetId':'time_shop',
			'triggerId':['time_shop'],
			'alignId':'time_shop',
			'zIndex':999999,
			'format':'-',
            'min':'<?php echo $this->_var['now_time']; ?>' //最小时间
		}
		xvDate(opts1);
		<?php endif; ?>
		
		$(".panl-items").perfectScrollbar("destroy");
		$(".panl-items").perfectScrollbar();
		
		//超值礼包
		$(".package_goods ul").perfectScrollbar("destroy");
		$(".package_goods ul").perfectScrollbar();
    </script>
    
    <?php elseif ($this->_var['step'] == "done" || $this->_var['step'] == "order_reload"): ?>
    <script type="text/javascript">
    	$(function(){
			$(".p-mode-list .p-mode-item").click(function(){
				var onlinepay_type = $(this).attr('flag');
				var order_sn = $(this).attr('order_sn');
				$.ajax({
					async: false,
					url:"flow.php?act=onlinepay_edit&onlinepay_type="+onlinepay_type+"&order_sn="+order_sn,
				});
			});
			
			
			$(".p-mode-item input").click(function(){
				var content = $("#pay_Dialog").html();
				pb({
					id:"payDialog",
					title:json_languages.payTitle,
					width:550,
					height:300,
					content:content,
					drag:false,
					foot:false
				});
			});
			
			//微信支付定时查询订单状态 by wanglu
    		checkOrder();

			//微信扫码
			$("[data-type='wxpay']").on("click",function(){
				var content = $("#wxpay_dialog").html();
				pb({
					id: "scanCode",
					title: "",
					width: 716,
					content: content,
					drag: true,
					foot: false,
					cl_cBtn: false,
					cBtn: false
				});
			});
		});
		
		var timer;
		function checkOrder(){
			var pay_name = "<?php echo $this->_var['order']['pay_name']; ?>";
			var pay_status = "<?php echo $this->_var['order']['pay_status']; ?>";
			var url = "flow.php?step=checkorder&order_id=<?php echo $this->_var['order']['order_id']; ?>";
			if(pay_name == "在线支付" && pay_status == 0){
				$.get(url, {}, function(data){
					//已付款
					if(data.code > 0 && data.pay_code == 'wxpay'){
						clearTimeout(timer);
						location.href = "respond.php?code=" + data.pay_code + "&status=1";
					}
				},'json');
			}
			timer = setTimeout("checkOrder()", 5000);
		}
    </script>
	<?php endif; ?>

    <script type="text/javascript">
        $(function(){
			$("input[name='store_order']").val(0);
			
            $(document).on('click', "[ectype='store_order']", function(){
                var i = 0;
                $("*[ectype='ckShopAll']").each(function(){
                    var t = $(this);
                    if(t.prop("checked") == true){
                        i++
                    }
                });
                
                if(i > 1){
                    pbDialog("不同商家的商品不可以批量门店自提","",0,'','',55);
                }else{
                    $("input[name='store_order']").val(1);
                    $("form[name='formCart']").submit();
                }
            });
        })  
    </script>  
</body>
</html>
