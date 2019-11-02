<div class="site-nav" id="site-nav">
    <div class="w w1200">
        <div class="fl">
            <?php 
$k = array (
  'name' => 'header_region',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
            <div class="txt-info" id="ECS_MEMBERZONE">
                <?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>	
            </div>
        </div>
        <ul class="quick-menu fr">
            <?php if ($this->_var['navigator_list']['top']): ?>
            <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
            <?php if (($this->_foreach['nav_top_list']['iteration'] - 1) < 4): ?>
            <li>
                <div class="dt"><a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew']): ?>target="_blank"<?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></div>
            </li>
            <li class="spacer"></li>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <?php endif; ?>
            <?php if ($this->_var['navigator_list']['top']): ?>
            <li class="li_dorpdown" data-ectype="dorpdown">
                <div class="dt dsc-cm"><?php echo $this->_var['lang']['Site_navigation']; ?><i class="iconfont icon-down"></i></div>
                <div class="dd dorpdown-layer">
                    <dl class="fore1">
                        <dt>特色主题</dt>
                        <dd>
                            <?php $_from = $this->_var['top_cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'topc_cats');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['topc_cats']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
                                <?php if (($this->_foreach['nav_top_list']['iteration'] - 1) < 3): ?>
                                    <div class="item"><a href="<?php echo $this->_var['topc_cats']['url']; ?>" target="_blank"><?php echo $this->_var['topc_cats']['cat_alias_name']; ?></a></div>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </dd>
                    </dl>
                    <dl class="fore2">
                        <dt>促销活动</dt>
                        <dd>
                            <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
                                <?php if (($this->_foreach['nav_top_list']['iteration'] - 1) >= 4): ?>
                                    <div class="item"><a href="<?php echo $this->_var['nav']['url']; ?>"<?php if ($this->_var['nav']['opennew']): ?> target="_blank"<?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></div>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </dd>
                    </dl>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="header header-cart">
    <div class="w w1200">
        <div class="logo">
            <div class="logoImg"><a href="<?php echo $this->_var['url_index']; ?>"><img src="themes/ecmoban_dsc2017/images/logo.gif" /></a></div>
            <div class="tit"><?php if ($this->_var['step'] == "cart"): ?><?php echo $this->_var['lang']['cat_list']; ?>（<em ectype="cartNum"></em>）<?php else: ?>结算页<?php endif; ?></div>
        </div>
        <?php if ($this->_var['step'] == "cart"): ?>
        <div class="dsc-search">
            <div class="form">
                <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm(this)" class="search-form">
                    <input autocomplete="off" onKeyUp="lookup(this.value);" name="keywords" type="text" id="keyword" value="<?php if ($this->_var['search_keywords']): ?><?php echo $this->_var['search_keywords']; ?><?php else: ?><?php 
$k = array (
  'name' => 'rand_keyword',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?><?php endif; ?>" class="search-text"/>
                    <input type="hidden" name="store_search_cmt" value="<?php echo empty($this->_var['search_type']) ? '0' : $this->_var['search_type']; ?>">
                    <button type="submit" class="button button-icon"><i></i></button>
                </form>
                
                <div class="suggestions_box" id="suggestions" style="display:none;">
                    <div class="suggestions_list" id="auto_suggestions_list">
                        &nbsp;
                    </div>
                </div>
                
            </div>
        </div>
        <?php else: ?>
        <div class="cart-stepflex">
            <div class="cart-step-item cur">
                <span>1.我的购物车</span>
                <i class="iconfont icon-arrow-right-alt"></i>
            </div>
            <div class="cart-step-item <?php if ($this->_var['step'] == 'checkout'): ?>curr<?php elseif ($this->_var['step'] == 'done' || $this->_var['step'] == 'order_reload' || $this->_var['step'] == 'pay_success'): ?>cur<?php endif; ?>">
                <span>2.填写订单信息</span>
                <i class="iconfont icon-arrow-right-alt"></i>
            </div>
            <div class="cart-step-item <?php if ($this->_var['step'] == 'done' || $this->_var['step'] == 'order_reload' || $this->_var['step'] == 'pay_success'): ?>curr<?php endif; ?>">
                <span>3.成功提交订<?php echo $this->_var['store_seller']; ?>单</span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>