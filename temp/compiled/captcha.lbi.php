<?php if ($this->_var['enabled_captcha']): ?>
<div class="item" ectype="captcha">
    <div class="item-info">
        <i class="iconfont icon-security"></i>
        <input type="text" id="captcha" name="captcha" class="text text-2" value="" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" autocomplete="off" />
        <img src="captcha_verify.php?captcha=is_login&<?php echo $this->_var['rand']; ?>" class="captcha_img fr" onClick="this.src='captcha_verify.php?captcha=is_login&'+Math.random()">
    </div>
</div>
<?php endif; ?>