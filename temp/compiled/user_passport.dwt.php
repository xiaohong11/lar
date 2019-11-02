<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<?php echo $this->fetch('library/js_languages_new.lbi'); ?>
<script type="text/javascript">
/*登录、注册、找回密码js语言包*/
<?php $_from = $this->_var['lang']['js_languages']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</head>

<body class="bg-ligtGary">
<?php if ($this->_var['action'] == 'login'): ?>
<div class="login">
    <div class="loginRegister-header">
        <div class="w w1200">
            <div class="logo">
                <div class="logoImg"><a href="./index.php" class="logo"><?php if ($this->_var['user_login_logo']): ?><img src="<?php echo $this->_var['user_login_logo']; ?>" /><?php endif; ?></a></div>
                <div class="logo-span">
                    <?php if ($this->_var['login_logo_pic']): ?><b style="background:url(<?php echo $this->_var['login_logo_pic']; ?>) no-repeat;"></b><?php endif; ?>
                </div>
            </div>
            <div class="header-href">
            <?php if ($this->_var['shop_reg_closed'] != 1): ?>
                <span>还没有账号<a href="user.php?act=register" class="jump"><?php echo $this->_var['lang']['Free_registration']; ?></a></span>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="login-wrap">
            <div class="w w1200">
                <div class="login-form">
                    <div class="coagent">
                    <?php if ($this->_var['website_list']): ?>
                        <div class="tit"><h3><?php echo $this->_var['lang']['Third_party_Lgion']; ?></h3><span></span></div>
                        <div class="coagent-warp">
                        <?php $_from = $this->_var['website_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'website');if (count($_from)):
    foreach ($_from AS $this->_var['website']):
?>
                            <?php if ($this->_var['website']['web_type'] == 'weixin'): ?>
                                <a href="wechat_oauth.php?act=login" class="<?php echo $this->_var['website']['web_type']; ?>"><b class="third-party-icon <?php echo $this->_var['website']['web_type']; ?>-icon"></b></a>
                            <?php else: ?>
                                <a href="user.php?act=oath&type=<?php echo $this->_var['website']['web_type']; ?>" class="<?php echo $this->_var['website']['web_type']; ?>"><b class="third-party-icon <?php echo $this->_var['website']['web_type']; ?>-icon"></b></a>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="login-box">
                        <div class="tit"><h3>账号登录</h3><span></span></div>
                        <div class="msg-wrap">
                            <div class="msg-error" style="display:none"><?php echo $this->_var['lang']['passport_one']; ?></div>
                        </div>
                        <div class="form">
                            <form name="formLogin" action="user.php" method="post" onSubmit="userLogin();return false;">
                                <div class="item">
                                    <div class="item-info">
                                        <i class="iconfont icon-name"></i>
                                        <input type="text" id="username" name="username" class="text" value="" placeholder="<?php echo $this->_var['lang']['label_username']; ?>" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="item" ectype="password">
                                    <div class="item-info">
                                        <i class="iconfont icon-password"></i>
                                        <input type="password" style="display:none"/>
                                        <input type="password" id="nloginpwd" name="password" class="text" value="" placeholder="<?php echo $this->_var['lang']['label_password']; ?>" autocomplete="off" />
                                    </div>
                                </div>
                                <?php echo $this->fetch('library/captcha.lbi'); ?>
                                <div class="item">
                                    <input id="remember" name="remember" type="checkbox" class="ui-checkbox">
                                    <label for="remember" class="ui-label"><?php echo $this->_var['lang']['remember']; ?></label>
                                </div>
                                <div class="item item-button">
                                    <input type="hidden" name="dsc_token" value="<?php echo empty($this->_var['dsc_token']) ? '0' : $this->_var['dsc_token']; ?>" autocomplete="off" />
                                    <input type="hidden" name="act" value="act_login" autocomplete="off" />
                                    <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" autocomplete="off" />
                                    <input type="submit" name="submit" id="loginSubmit" value="<?php echo $this->_var['lang']['signin_now']; ?>" class="btn sc-redBg-btn">
                                </div>
                                <a href="user.php?act=get_password" class="notpwd gary"><?php echo $this->_var['lang']['passportforgot_password']; ?></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
$k = array (
  'name' => 'get_adv_child',
  'ad_arr' => $this->_var['login_banner'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>  
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($this->_var['action'] == 'register'): ?>
<div class="register">
    <div class="loginRegister-header">
        <div class="w w1200">
            <div class="logo">
                <div class="logoImg"><a href="./index.php" class="logo"><?php if ($this->_var['user_login_logo']): ?><img src="<?php echo $this->_var['user_login_logo']; ?>" /><?php endif; ?></a></div>
                <div class="logo-span">
                    <?php if ($this->_var['login_logo_pic']): ?><b style="background:url(<?php echo $this->_var['login_logo_pic']; ?>) no-repeat;"></b><?php endif; ?>
                </div>
            </div>
            <div class="header-href">
                <span>已注册可<a href="user.php" class="jump"><?php echo $this->_var['lang']['login_here']; ?></a></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="w w1200">
            <div class="register-wrap">
                <div class="register-adv">
                <?php 
$k = array (
  'name' => 'get_adv',
  'logo_name' => $this->_var['regist_banner'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
                </div>
                <div class="register-form">
                    <div class="form form-other">
                        <form action="user.php" method="post" name="formUser">
                            <div class="item">
                                <div class="item-label"><?php echo $this->_var['lang']['username_bind']; ?></div>
                                <div class="item-info">
                                    <input type="text" name="username" id="username" class="text" value="" autocomplete="off" />
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <div class="item">
                                <div class="item-label"><?php echo $this->_var['lang']['bind_password']; ?></div>
                                <div class="item-info">
                                    <input type="password" style="display:none"/>
                                    <input type="password" name="password" id="pwd" class="text" value="" autocomplete="off" />
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <div class="item">
                                <div class="item-label"><?php echo $this->_var['lang']['bind_password2']; ?></div>
                                <div class="item-info">
                                    <input type="password" style="display:none"/>
                                    <input type="password" name="confirm_password" id="pwdRepeat" class="text" value="" autocomplete="off" />
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <div class="item" id="phone_yz">
                                <div class="item-label"><?php echo $this->_var['lang']['bind_phone']; ?></div>
                                <div class="item-info">
                                    <input type="text" name="mobile_phone" id="mobile_phone" class="text" value="" autocomplete="off" />
                                    <a href="javascript:void(0);" class="meswitch" ectype="meSwitch" data-type="phone"><?php echo $this->_var['lang']['or_login']; ?><?php echo $this->_var['lang']['email_yanzheng']; ?></a>
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <div class="item" id="email_yz" style="display:none;">
                                <div class="item-label"><?php echo $this->_var['lang']['email_label']; ?></div>
                                <div class="item-info">
                                    <input type="text" name="email" id="regName" class="text ignore" value="" autocomplete="off" />
                                    <a href="javascript:void(0);" class="meswitch" ectype="meSwitch" data-type="email"><?php echo $this->_var['lang']['or_login']; ?><?php echo $this->_var['lang']['phone_yanzheng']; ?></a>
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            
                            <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
                            <?php if ($this->_var['field']['id'] == 6): ?>
                            <div class="item" style="overflow:visible;">
                                <div class="item-label"><?php echo $this->_var['lang']['Prompt_problem']; ?></div>
                                <div class="item-info" style=" border:0;">
                                    <div id="divselect" class="divselect">
                                      <div class="cite"><span><?php echo $this->_var['lang']['passwd_question']; ?></span></div>
                                      <ul>
                                         <?php $_from = $this->_var['passwd_questions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
                                         <li><a href="javascript:;" data-value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['val']; ?></a></li>
                                         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                      </ul>
                                      <input name="sel_question" type="hidden" value="" id="passwd_quesetion" autocomplete="off">
                                    </div>
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <div class="item">
                                <div class="item-label"><?php echo $this->_var['lang']['passwd_answer_useer']; ?></div>
                                <div class="item-info">
                                    <input type="text" name="passwd_answer" maxlength="20" class="text" value="" placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>" autocomplete="off" />
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <?php else: ?>
                            <?php if ($this->_var['field']['reg_field_name'] != '手机'): ?>
                            <div class="item">
                                <div class="item-label"><?php echo $this->_var['field']['reg_field_name']; ?></div>
                                <div class="item-info">
                                    <input name="extend_field<?php echo $this->_var['field']['id']; ?>" id="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" maxlength="35" class="text"<?php if ($this->_var['field']['is_need']): ?> required data-msg="<i class='iconfont icon-minus-sign'></i>此处是必填字段"<?php endif; ?> autocomplete="off" />
                                </div>
                                <div class="input-tip"><span class="extend_field<?php echo $this->_var['field']['id']; ?>"></span></div>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            
                            <?php if ($this->_var['enabled_captcha']): ?>
                            <div class="item">
                                <div class="item-label"><?php echo $this->_var['lang']['Code_bind']; ?></div>
                                <div class="item-info">
                                    <input type="text" id="captcha" name="captcha" class="text text-2 fl" value="" autocomplete="off" />
                                    <img src="captcha_verify.php?captcha=is_register_phone&<?php echo $this->_var['rand']; ?>" class="captcha_img fl" onClick="this.src='captcha_verify.php?captcha=is_register_phone&'+Math.random()">
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <?php endif; ?>
                            <?php if ($this->_var['sms_register']): ?>
                            <div class="item" id="code_mobile">
                                <div class="item-label"><?php echo $this->_var['lang']['bindMobile_code']; ?></div>
                                <div class="item-info">
                                    <input type="text" id="sms" name="mobile_code" class="text text-2" value="" autocomplete="off" />
                                    <a href="javascript:sendSms();" id="zphone" class="sms-btn"><?php echo $this->_var['lang']['getMobile_code']; ?></a>
                                </div>
                                <div class="input-tip"><label id="phone_notice"></label></div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="item" id="code_email" style="display:none;">
                                <div class="item-label"><?php echo $this->_var['lang']['comment_captcha_code']; ?></div>
                                <div class="item-info">
                                    <input type="text" name="send_code" id="send_code" class="text text-2 ignore" value="" autocomplete="off" />
                                    <a href="javascript:sendChangeEmail(1);" id="zemail" class="sms-btn"><?php echo $this->_var['lang']['get_verification_code']; ?></a>
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            
                            <div class="item item2">
                                <div class="item-checkbox">
                                    <input type="checkbox" id="clause2" class="ui-solid-checkbox" checked="checked" value="1" name="mobileagreement">
                                    <label class="ui-solid-label" for="clause2"><?php echo $this->_var['lang']['agreed_bind']; ?><a href="<?php echo $this->_var['register_article_id']; ?>" class="ftx-05" target="_blank">《<?php echo $this->_var['dwt_shop_name']; ?><?php echo $this->_var['lang']['protocol_bind']; ?>》</a></label>
                                </div>
                                <div class="input-tip"></div>
                            </div>
                            <div class="item item2 item-button">
                                <input type="hidden" name="flag" id="flag" value='register' autocomplete="off" />
                                <input name="register_type" type="hidden" value="1" autocomplete="off" />
                                <input type="hidden" name="seccode" id="seccode" value="<?php echo $this->_var['sms_security_code']; ?>" autocomplete="off" />
                                <input name="act" type="hidden" value="act_register" autocomplete="off" >
                                <input name="register_mode" type="hidden" value="1" autocomplete="off" >
                                <input id="phone_code_callback" type="hidden" value="0" autocomplete="off" >
                                <input id="phone_captcha_verification" type="hidden" value="" autocomplete="off" />
                                <input id="phone_verification" type="hidden" value="0" autocomplete="off" />
                                <input id="email_verification" type="hidden" value="0" autocomplete="off" />
                                <input id="enabled_captcha" type="hidden" value="<?php echo $this->_var['enabled_captcha']; ?>" autocomplete="off" />
                                <input type="submit" id="registsubmit" name="Submit" maxlength="8" class="btn sc-redBg-btn" value="<?php echo $this->_var['lang']['register_now']; ?>"/>
                            </div>
                        </form>
                    </div>            
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($this->_var['action'] == 'get_password'): ?>
<div class="get_pwd">
    <div class="loginRegister-header">
        <div class="w w1200">
            <div class="logo">
                <div class="logoImg"><a href="./index.php" class="logo"><?php if ($this->_var['user_login_logo']): ?><img src="<?php echo $this->_var['user_login_logo']; ?>" /><?php endif; ?></a></div>
                <div class="logo-span">
                    <?php if ($this->_var['login_logo_pic']): ?><b style="background:url(<?php echo $this->_var['login_logo_pic']; ?>) no-repeat;"></b><?php endif; ?>
                </div>
            </div>
            <div class="header-href">
                <span>已注册可<a href="user.php" class="jump"><?php echo $this->_var['lang']['login_here']; ?></a></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="w w1200">
            <div class="get_pwd_warp">
                <div class="get_pwd_form">
                    
                    <div class="form form-other" ectype="formWarp">
                        <div class="item item-other">
                            <div class="item-label">&nbsp;</div>
                            <div class="gp-tab<?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?><?php if ($this->_var['field']['id'] == 6): ?> gptabThree<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>" ectype="gpTab">
                                <ul>
                                    <li class="curr"><i class="iconfont icon-mobile-phone"></i><span>手机找回</span></li>
                                    <li><i class="iconfont icon-email"></i><span>邮箱找回</span></li>
                                    <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?><?php if ($this->_var['field']['id'] == 6): ?><li ectype="gptabLast"><i class="iconfont icon-icon02"></i><span><?php echo $this->_var['lang']['Regist_problem']; ?></span></li><?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="gp-content" ectype="gpContent">
                            <div class="gp-warp formPhone" style="display:block;">
                                <form action="user.php" method="post" name="getPhonePassword" ectype="form">
                                    <div class="item">
                                        <div class="item-label"><?php echo $this->_var['lang']['bind_phone']; ?></div>
                                        <div class="item-info"><input type="text" name="mobile_phone" id="mobile_phone" class="text" autocomplete="off" placeholder="<?php echo $this->_var['lang']['bind_mobile_regist']; ?>" /></div>
                                        <div class="input-tip" id="phone_notice"></div>
                                    </div>
                                    <?php if ($this->_var['enabled_captcha']): ?>
                                    <div class="item">
                                        <div class="item-label"><?php echo $this->_var['lang']['Code_bind']; ?></div>
                                        <div class="item-info">
                                            <input type="hidden" name="seKey" value="get_phone_password" autocomplete="off" />
                                            <input type="text" id="mobile_captcha" name="captcha" class="text text-2 fl" value="" maxlength="6"  placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" autocomplete="off" />
                                            <img src="captcha_verify.php?captcha=is_get_phone_password&<?php echo $this->_var['rand']; ?>" alt="captcha" name="img_captcha" onClick="this.src='captcha_verify.php?captcha=is_get_phone_password&'+Math.random()" data-key="get_phone_password" class="captcha_img fl">
                                        	<span class="fr lh30 red">看不清，点击图片换一张</span>
                                        </div>
                                        <div class="input-tip"></div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="item">
                                        <div class="item-label">手机验证码</div>
                                        <div class="item-info phone_code">
                                            <input name="sms_value" id="sms_value" type="hidden" value="sms_find_signin" autocomplete="off" />
                                            <input type="text" id="sms" name="mobile_code" class="text text-2"  maxlength="6" value="" autocomplete="off" placeholder="<?php echo $this->_var['lang']['msg_mobile_code']; ?>"/>
                                            <a href="javascript:sendSms();" id="zphone" class="sms-btn"><?php echo $this->_var['lang']['get_verification_code']; ?></a>
                                        </div>
                                        <div class="input-tip"></div>
                                    </div>
                                    <div class="item item2 item-button">
                                        <input type="hidden" name="flag" id="flag" value='forget' autocomplete="off" />
                                        <input type="hidden" name="seccode" id="seccode" value="<?php echo $this->_var['sms_security_code']; ?>" autocomplete="off" />
                                        <input type="hidden" name="act" value="get_pwd_mobile" autocomplete="off" />
                                        <input type="submit" name="submit" id="get-phone-submit" value="提&nbsp;交" class="btn sc-redBg-btn" ectype="submitBtn">
                                    </div>
                                </form>
                            </div>
                            <div class="gp-warp formEmail">
                                <form action="user.php" method="post" name="getEmailPassword" ectype="form">
                                    <div class="item">
                                        <div class="item-label"><?php echo $this->_var['lang']['username_bind']; ?></div>
                                        <div class="item-info"><input type="text" name="user_name" class="text" placeholder="<?php echo $this->_var['lang']['username']; ?>" autocomplete="off" /></div>
                                        <div class="input-tip"></div>
                                    </div>
                                    <div class="item">
                                        <div class="item-label">邮 箱 账 号</div>
                                        <div class="item-info"><input type="text" name="email" id="email" class="text" placeholder="<?php echo $this->_var['lang']['email_reset']; ?>" autocomplete="off" /></div>
                                        <div class="input-tip"></div>
                                    </div>

                                    <?php if ($this->_var['enabled_captcha']): ?>
                                    <div class="item">
                                        <div class="item-label"><?php echo $this->_var['lang']['Code_bind']; ?></div>
                                        <div class="item-info">
                                            <input type="text" id="captcha" name="captcha" class="text text-2 fl" value="" maxlength="6"  placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" autocomplete="off" />
                                            <img src="captcha_verify.php?captcha=is_get_password&<?php echo $this->_var['rand']; ?>" alt="captcha" name="img_captcha" onClick="this.src='captcha_verify.php?captcha=is_get_password&'+Math.random()" data-key="get_password" class="captcha_img fl">
                                        	<span class="fr lh30 red">看不清，点击图片换一张</span>
                                        </div>
                                        <div class="input-tip"></div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="item item2 item-button">
                                        <input type="hidden" name="act" value="send_pwd_email" autocomplete="off"/>
                                        <input type="hidden" id="captcha_verification" name="captcha_verification" value="" autocomplete="off" />
                                        <input type="hidden" id="email_enabled_captcha" value="<?php echo $this->_var['enabled_captcha']; ?>" autocomplete="off" />
                                        <input type="submit" name="submit" id="get-phone-submit" value="提&nbsp;交" class="btn sc-redBg-btn" ectype="submitBtn">
                                    </div>
                                </form>
                            </div>
                            
                            <div class="gp-warp formWenti" ectype="gpwarpLast" style="display:none;">
                                <form action="user.php" method="post" name="getWentiPassword" ectype="form">
                                <div class="item">
                                	<div class="item-label"><?php echo $this->_var['lang']['username_bind']; ?></div>
                                    <div class="item-info"><input name="user_name" type="text" class="text" value="" placeholder="<?php echo $this->_var['lang']['username']; ?>" autocomplete="off" /></div>
                                    <div class="input-tip"></div>
                                </div>
                                <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
                                <?php if ($this->_var['field']['id'] == 6): ?>
                                <div class="item">
                                	<div class="item-label">提示问题：</div>
                                    <div class="fl">
                                        <div id="divselect" class="divselect">
                                          <div class="cite"><span><?php echo $this->_var['lang']['passwd_question']; ?></span></div>
                                          <ul>
                                             <?php $_from = $this->_var['passwd_questions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
                                             <li><a href="javascript:;" data-value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['val']; ?></a></li>
                                             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                          </ul>
                                        </div>
                                        <input name="sel_question" type="hidden" value="" id="passwd_quesetion" autocomplete="off">
                                        <input name="is_passwd_questions" type="hidden" value="1" autocomplete="off" />
                                    </div>
                                    <div class="input-tip"></div>
                                </div>
                                <div class="item">
                                	<div class="item-label">问题答案：</div>
                                    <div class="item-info">
                                        <input name="passwd_answer" type="text" size="25" class="text" maxlengt='20' placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>" autocomplete="off" />
                                    </div>
                                    <div class="input-tip"></div>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                <?php if ($this->_var['enabled_captcha']): ?>
                                <div class="item">
                                    <div class="item-label"><?php echo $this->_var['lang']['Code_bind']; ?></div>
                                    <div class="item-info">
                                        <input type="hidden" name="seKey" value="get_password" autocomplete="off" />
                                        <input type="text" id="mobile_captcha" name="captcha" class="text text-2 fl" value="" maxlength="6"  placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" autocomplete="off" />
                                        <img src="captcha_verify.php?captcha=get_pwd_question&<?php echo $this->_var['rand']; ?>" alt="captcha" name="img_captcha" onClick="this.src='captcha_verify.php?captcha=get_pwd_question&'+Math.random()" data-key="psw_question" class="captcha_img fl">
                                        <span class="fr lh30 red">看不清，点击图片换一张</span>
                                    </div>
                                    <div class="input-tip"></div>
                                </div>
                                <?php endif; ?>
                                <div class="item item2 item-button">
                                    <input type="hidden" name="act" value="check_answer" autocomplete="off" />
                                    <input type="submit" name="submit" value="提&nbsp;交" class="btn sc-redBg-btn" ectype="submitBtn">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($this->_var['action'] == 'reset_password'): ?> 
<div class="get_pwd">
    <div class="loginRegister-header">
        <div class="w w1200">
            <div class="logo">
                <div class="logoImg"><a href="./index.php" class="logo"><?php if ($this->_var['user_login_logo']): ?><img src="<?php echo $this->_var['user_login_logo']; ?>" /><?php endif; ?></a></div>
                <div class="logo-span">
                    <?php if ($this->_var['login_logo_pic']): ?><b style="background:url(<?php echo $this->_var['login_logo_pic']; ?>) no-repeat;"></b><?php endif; ?>
                </div>
            </div>
            <div class="header-href">
                <span>已注册可<a href="user.php" class="jump"><?php echo $this->_var['lang']['login_here']; ?></a></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="w w1200">
            <div class="get_pwd_warp">
                <div class="get_pwd_form">
                    
                    <div class="form form-other" >
                        <form action="user.php" method="post" name="getPassword2" ectype="form">
                            <div class="item item-other">
                                <div class="item-label">&nbsp;</div>
                                <div class="gp-tit"><i class="iconfont icon-password"></i><?php echo $this->_var['lang']['reset_password']; ?></div>
                            </div>
                            <div class="gp-content">
                                <div class="gp-warp" style="display:block;">
                                    <div class="item">
                                        <div class="item-label">设 置 密 码</div>
                                        <div class="item-info">
                                            <input type="password" style="display:none"/>
                                            <input name="new_password" type="password" id="pwd" class="text" autocomplete="off" placeholder="<?php echo $this->_var['lang']['new_password']; ?>"/>
                                        </div>
                                        <div class="input-tip"></div>
                                    </div>
                                    <div class="item">
                                        <div class="item-label">确 认 密 码</div>
                                        <div class="item-info">
                                            <input type="password" style="display:none"/>
                                            <input name="confirm_password" type="password" id="pwdRepeat" class="text" autocomplete="off"placeholder="<?php echo $this->_var['lang']['confirm_password']; ?>" />
                                        </div>
                                        <div class="input-tip"></div>
                                    </div>
                                    <?php if ($this->_var['enabled_captcha']): ?>
                                    <div class="item">
                                        <div class="item-label"><?php echo $this->_var['lang']['Code_bind']; ?></div>
                                        <div class="item-info">
                                            <input type="text" id="captcha" name="captcha" class="text text-2 fl" value="" autocomplete="off" maxlength="6"  placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>"/>
                                            <img src="captcha_verify.php?captcha=is_get_password&<?php echo $this->_var['rand']; ?>" alt="captcha" name="img_captcha" onClick="this.src='captcha_verify.php?captcha=is_get_password&'+Math.random()" class="captcha_img fl" data-key="get_password">
                                        	<span class="fr lh30 red">看不清，点击图片换一张</span>
                                        </div>
                                        <div class="input-tip"></div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="item item2 item-button">
                                        <input type="hidden" name="act" value="act_edit_password" />
                                        <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
                                        <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
                                        <input type="submit" name="submit" id="get-phone-submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn sc-redBg-btn" ectype="submitBtn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php echo $this->fetch('library/page_footer_flow.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'user.js,user_register.js,utils.js,jquery.SuperSlide.2.1.1.js,./sms/sms.js,perfect-scrollbar/perfect-scrollbar.min.js,jquery.validation.min.js')); ?>
<script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/dsc-common.js"></script>
<script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/jquery.purebox.js"></script>
<script type="text/javascript">
$(function(){
	if(document.getElementById("seccode")){
		$("#seccode").val(<?php echo empty($this->_var['sms_security_code']) ? '0' : $this->_var['sms_security_code']; ?>);
	}
	
	<?php if ($this->_var['action'] == 'get_password'): ?>
	//找回密码方式切换
	$("*[ectype='formWarp']").slide({titCell:"*[ectype='gpTab'] li",mainCell:"*[ectype='gpContent']",effect:"fade",trigger:"click",titOnClassName:"curr"});
	<?php endif; ?>
	
	<?php if ($this->_var['action'] == 'register'): ?>
	//邮箱验证和手机验证切换
	$("*[ectype='meSwitch']").on("click",function(){
		var type = $(this).data("type");
		
		if(type == "phone"){
			$("#email_yz,#code_email").show(); //邮箱验证 邮箱号和邮箱验证码显示
			$("#phone_yz,#code_mobile").hide(); //邮箱验证 手机号码和短信隐藏
			
			$("input[name='register_type']").val(0); //邮箱验证标识
			$("input[name='mobile_phone']").val(""); //手机号码清空
			$("input[name='mobile_phone'],input[name='mobile_code']").addClass("ignore"); //邮箱验证 邮箱和邮箱验证码添加验证标识
			$("input[name='email'],input[name='send_code']").removeClass("ignore"); //邮箱验证 手机号码和短信去除验证标识
		}else{
			$("#email_yz,#code_email").hide(); //手机验证 邮箱号和邮箱验证码隐藏
			$("#phone_yz,#code_mobile").show(); //手机验证 手机号码和短信显示
			
			$("input[name='register_type']").val(1); //手机注册标识
			$("input[name='mobile_phone'],input[name='mobile_code']").removeClass("ignore"); //手机验证 手机号码和短信验证标识
			$("input[name='email'],input[name='send_code']").addClass("ignore"); //手机验证 邮箱和邮箱验证码去除验证标识
		}
	});
	<?php endif; ?>
	
	//注册问题下拉
	$.divselect("#divselect","#passwd_quesetion");
});
</script>
</body>
</html>

