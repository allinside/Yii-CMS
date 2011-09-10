<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $this->meta_title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <?php
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile('/css/site/style.css');
    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile('/js/site/cufon-yui.js');
    $cs->registerScriptFile('/js/site/arial.js');
    $cs->registerScriptFile('/js/site/cuf_run.js');
    $cs->registerScriptFile('/js/site/radius.js');
    ?>
</head>
<body>
<div class="main">
    <div class="header">
        <div class="header_resize">
            <div class="menu_nav">
                <?php $this->widget('TopMenu'); ?>
            </div>
            <div class="logo">
                <h1>
                    <a href="/">Арт <small>Проект</small></a>
                </h1>
            </div>

            <?php $this->widget('Langs'); ?>
            
            <div class="clr"></div>
        </div>
    </div>
    <div class="content">
        <div class="content_resize">
            <div class="mainbar">
                <div class="article">
                    <h2><?php echo $this->page_title; ?></h2>

                    <?php echo $content; ?>
                </div>
            </div>
            <div class="sidebar">
                <div class="searchform">
                            <form id="formsearch" name="formsearch" method="post" action="#">
                    <span>
                    <input name="editbox_search" class="editbox_search" id="editbox_search" maxlength="80" value="Search our ste:" type="text"/>
                    </span>
                                <input name="button_search" src="/images/site/search_btn.gif" class="button_search" type="image"/>
                            </form>
                </div>
                <div class="gadget">
                    <h2 class="star"><span>Sidebar</span> Menu</h2>

                    <div class="clr"></div>
                    <ul class="sb_menu">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">TemplateInfo</a></li>
                        <li><a href="#">Style Demo</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Archives</a></li>
                        <li><a href="#">Web Templates</a></li>
                    </ul>
                </div>
                <div class="gadget">
                    <h2 class="star"><span>Sponsors</span></h2>

                    <div class="clr"></div>
                    <ul class="ex_menu">
                        <li><a href="http://www.dreamtemplate.com">DreamTemplate</a><br/>
                            Over 6,000+ Premium Web Templates
                        </li>
                        <li><a href="http://www.templatesold.com/">TemplateSOLD</a><br/>
                            Premium WordPress &amp; Joomla Themes
                        </li>
                        <li><a href="http://www.imhosted.com">ImHosted.com</a><br/>
                            Affordable Web Hosting Provider
                        </li>
                        <li><a href="http://www.myvectorstore.com">MyVectorStore</a><br/>
                            Royalty Free Stock Icons
                        </li>
                        <li><a href="http://www.evrsoft.com">Evrsoft</a><br/>
                            Website Builder Software &amp; Tools
                        </li>
                        <li><a href="http://www.csshub.com/">CSS Hub</a><br/>
                            Premium CSS Templates
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <div class="fbg">
        <div class="fbg_resize">
            <div class="col c3">
                <h2><span>Contact</span></h2>

                <p>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue.</p>

                <p><a href="#">support@yoursite.com</a></p>

                <p>+1 (123) 444-5677<br/>
                    +1 (123) 444-5678</p>

                <p>Address: 123 TemplateAccess Rd1</p>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <div class="footer">
        <div class="footer_resize">
            <?php echo PageBlock::model()->getText('copyright'); ?>
            <div class="clr"></div>
        </div>
    </div>
</div>
</body>
</html>
