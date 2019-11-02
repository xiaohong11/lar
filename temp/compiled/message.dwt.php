<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<?php if ($this->_var['auto_redirect']): ?>
<meta http-equiv="refresh" content="3;URL=<?php echo $this->_var['message']['back_url']; ?>" />
<?php endif; ?>

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<?php echo $this->fetch('library/js_languages_new.lbi'); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header_common.lbi'); ?>    
<div class="w w1200">
    <div class="no_records message_records">
        <i class="no_icon_two"></i>
        <div class="no_info no_info_line w500">
            <h3><?php echo $this->_var['message']['content']; ?></h3>
            <div class="no_btn">
            	<?php if ($this->_var['message']['url_info']): ?>
          		<?php $_from = $this->_var['message']['url_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('info', 'url');if (count($_from)):
    foreach ($_from AS $this->_var['info'] => $this->_var['url']):
?>
                <a href="<?php echo $this->_var['url']; ?>" class="btn sc-redBg-btn"><?php echo $this->_var['info']; ?></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        		<?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
<script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/dsc-common.js"></script>
</body>
</html>
