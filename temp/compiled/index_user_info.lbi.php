<div class="vip-con">
    <div class="avatar">
        <a href="user.php?act=profile"><img src="<?php if ($this->_var['user_id']): ?><?php if ($this->_var['info']['user_picture']): ?><?php echo $this->_var['info']['user_picture']; ?><?php else: ?>themes/<?php echo $GLOBALS['_CFG']['template']; ?>/images/touxiang.jpg<?php endif; ?><?php else: ?>themes/<?php echo $GLOBALS['_CFG']['template']; ?>/images/avatar.png<?php endif; ?>"></a>
    </div>
    <div class="login-info">
        <?php if ($this->_var['user_id']): ?>
            <span>Hi，<?php if ($this->_var['info']['nick_name']): ?><?php echo $this->_var['info']['nick_name']; ?><?php else: ?>欢迎来到<?php echo $GLOBALS['_CFG']['shop_name']; ?>!<?php endif; ?></span>
            <a href="<?php echo $this->_var['site_domain']; ?>user.php" class="login-button login-success">进入会员中心</a>
        <?php else: ?>
            <span>Hi，欢迎来到<?php echo $GLOBALS['_CFG']['shop_name']; ?>!</span>
            <a href="<?php echo $this->_var['site_domain']; ?>user.php" class="login-button"><?php echo $this->_var['lang']['please_login']; ?></a>
            <a href="merchants.php" target="_blank" class="register_button">我要开店</a>
        <?php endif; ?>
    </div>
    <?php if ($this->_var['index_article_cat']): ?>
    <div class="vip-item">
        <div class="tit">
            <?php $_from = $this->_var['index_article_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'cat_0_15055600_1572699756');$this->_foreach['cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['cat_0_15055600_1572699756']):
        $this->_foreach['cat']['iteration']++;
?>
            <a href="javascript:void(0);" class="tab_head_item"><?php echo $this->_var['cat_0_15055600_1572699756']['cat']['name']; ?></a>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
        <div class="con">
            <?php $_from = $this->_var['index_article_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_0_15059700_1572699756');$this->_foreach['cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat']['total'] > 0):
    foreach ($_from AS $this->_var['cat_0_15059700_1572699756']):
        $this->_foreach['cat']['iteration']++;
?>
            <ul <?php if (! ($this->_foreach['cat']['iteration'] <= 1)): ?>style="display:none;"<?php endif; ?>>
                <?php $_from = $this->_var['cat_0_15059700_1572699756']['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article']['iteration']++;
?>
                <li><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank"><?php echo $this->_var['article']['title']; ?></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="vip-item">
        <div class="tit">快捷入口</div>
        <div class="kj_con">
            <div class="item item_1">
                <a href="history_list.php" target="_blank">
                    <i class="iconfont icon-browse"></i>
                    <span>我的浏览</span>
                </a>
            </div>
            <div class="item item_2">
                <a href="user.php?act=collection_list" target="_blank">
                    <i class="iconfont icon-zan-alt"></i>
                    <span>我的收藏</span>
                </a>
            </div>
            <div class="item item_3">
                <a href="user.php?act=order_list" target="_blank">
                    <i class="iconfont icon-order"></i>
                    <span>我的订单</span>
                </a>
            </div>
            <div class="item item_4">
                <a href="user.php?act=account_safe" target="_blank">
                    <i class="iconfont icon-password-alt"></i>
                    <span>账号安全</span>
                </a>
            </div>
            <div class="item item_5">
                <a href="user.php?act=affiliate" target="_blank">
                    <i class="iconfont icon-share-alt"></i>
                    <span>我要分享</span>
                </a>
            </div>
            <div class="item item_6">
                <a href="merchants.php" target="_blank">
                    <i class="iconfont icon-settled"></i>
                    <span>商家入驻</span>
                </a>
            </div>
        </div>
    </div>
</div>