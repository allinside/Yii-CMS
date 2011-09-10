<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $this->page_title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="/css/site/style.css" type="text/css" rel="stylesheet"/>

    <?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    ?>

    <script type="text/javascript" src="/js/site/script.js"></script>
    <script type="text/javascript" src="/js/site/auth.js"></script>
    <!--[if IE 6]>
    <link href="/css/site/style_ie6.css" type="text/css" rel="stylesheet"/>
    <![endif]-->

    <link href="/css/yii/form.css" type="text/css" rel="stylesheet"/>
    <link href="/css/admin/messages.css" type="text/css" rel="stylesheet"/>
    
    <link media="all" type="text/css" href="/css/site/jquery-ui.css" rel="stylesheet"/>
    
</head>
<body>
<div id="wrapper">
    <div id="header" style="position:relative">

        <a href="/" class="logo"><img src="/images/site/logo.jpg" class="opacity" alt=""/></a>

        <div id="slogan">
            <div class="text1"><?php echo Yii::t('main', 'ПЕРВЫЙ В РОССИИ КЛУБ СПЕЦИАЛИСТОВ ПО РАСПЕРЕДЕЛЕНИЮ ЭЛЕКТРОЭНЕРГИИ'); ?></div>
            <div class="text2"><?php echo Yii::t('main', 'ТРАДИЦИИ ТЕХНОЛОГИИ ИННОВАЦИИ'); ?></div>
        </div>
        <div id="auth_block">
            <?php if (Yii::app()->user->isGuest): ?>
				<?php $page_id = Yii::app()->language == 'ru' ? 7 : 18; ?>

                <a href="/page/<?php echo $page_id; ?>" class='registr'><?php echo Yii::t('main', 'Как стать членом Клуба?'); ?></a>

                <a href="#" id="login_link"><?php echo Yii::t('main', 'Войти'); ?></a>
            <?php else: ?>
                <a href="/users/user/logout" class="registr"><?php echo Yii::t('main', 'Выход'); ?></a>
                <div style="text-align:right;padding-right:55px !important"><a href=""><?php echo Yii::app()->user->name; ?></a></div>
            <?php endif ?>

            <br clear="all"/>

			<div id="auth_form">
                <div class="auth_top"></div>
                <div class="auth_center">
                    <img class="auth_close" src="/images/site/auth_close.png" alt="" />
                    <br clear="all" />
                    <form id="login_form">
                        <table cellpadding="0" cellspacing="0">
                            <tr>

                                <td>Email</td>
                                <td><input class="auth_text" type="text" id="auth_email" value="&nbsp;" /></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('main', 'Пароль'); ?></td>
                                <td><input class="auth_text" type="password" id="auth_pass" value="" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" id="login_form_msg" style="color:#CC6666"></td>
                            </tr>
                            <tr>

                                <td align="center">
                                    <img src="/images/site/c_loader.gif" border="0" id="auth_loader" style="display:none" />
                                </td>
                                <td>
                                    <input type="submit" value="<?php echo Yii::t('main', 'Войти'); ?>" id="auth_submit" class="auth_enter" />
                                    <input type="checkbox" id="check" />
                                    <label for="check"><?php echo Yii::t('main', 'Запомнить'); ?></label>
                                </td>
                            </tr>
                            <tr>

                                <td>&nbsp;</td>
                                <td><a href=""><?php echo Yii::t('main', 'Напомнить пароль'); ?></a></td>
                            </tr>
                        </table>
                        
                    </form>
                </div>
                <div class="auth_bot"></div>
            </div>

            <div id="search_block">
                <?php $search_label = Yii::t('main', 'Поиск по сайту'); ?>
                <form action="<?php echo $this->url('/search'); ?>">
                    <input type="submit" id="search_button" value=""/>
                    <input type="text" name="query" id="search_text" class="button" value="<?php echo $search_label; ?>" onblur="if (this.value == '') {this.value = '<?php echo $search_label; ?>';}"
                           onfocus="if (this.value == '<?php echo $search_label; ?>') {this.value = '';}"/>
                </form>
            </div>
        </div>
        <br clear="all"/>

        <div class="surr_events">
            <?php $this->widget('ActionsSidebar'); ?>
        </div>

        <div id="header_bkg">
            <!--<div id="header_title">
                <div class="white_20" style="padding-top:8px;padding-bottom:8px">ЭЛЕКТРОРАСПРЕДЕЛИТЕЛЬНЫЙ КОМПЛЕКС РОССИИ</div>
                <div class="white_20">НА ПУТИ ИННОВАЦИОННОГО РАЗВИТИЯ</div>
            </div>-->
            <br clear="all"/>
        </div>
        <div class="menu">
            <div class="left_menu"></div>
            <div class="center_menu">

            	<?php $this->widget('TopMenu'); ?>

            </div>
            <div class="right_menu"></div>
        </div>
    </div>
    <div id="content">
