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
                <h1><a href="#">winglobal
                    <small>put your slogan here</small>
                </a></h1>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <div class="content">
        <div class="content_resize">
            <div class="mainbar">
                <div class="article">
                    <h2><span>Support to</span> Company Name</h2>

                    <div class="clr"></div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Suspendisse nulla ligula, blandit ultricies aliquet ac,
                        lobortis in massa. Nunc dolor sem, tincidunt vitae viverra in, egestas sed lacus.</strong> Etiam in ullamcorper felis. Nulla
                        cursus feugiat leo, ut dictum metus semper a. Vivamus euismod, arcu gravida sollicitudin vestibulum, quam sem tempus quam,
                        quis ullamcorper erat nunc in massa. Donec aliquet ante non diam sollicitudin quis auctor velit sodales. Morbi neque est,
                        posuere at fringilla non, mollis nec nibh. Sed commodo tortor nec sem tincidunt mattis. Nam convallis aliquam nibh eu luctus.
                        Nunc vel tincidunt lacus. Suspendisse sit amet pulvinar ante.</p>

                    <p>Phasellus diam justo, laoreet vel vulputate eu, congue vel est. Maecenas eros libero, sollicitudin a vulputate fermentum,
                        ultrices vel lacus. Nam in metus non augue fermentum consequat ultrices ac enim. Integer aliquam urna non diam aliquam eget
                        hendrerit sem molestie.</p>

                    <p><strong>Lorem ipsum dolor sit amet</strong></p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eget bibendum tellus. Nunc vel imperdiet tellus. Mauris
                        ornare aliquam urna, accumsan bibendum eros auctor ac.</p>
                    <ul class="sb_menu">
                        <li><a href="#"><strong>Lorem ipsum</strong></a></li>
                        <li><a href="#"><strong>Lorem ipsum</strong></a></li>
                        <li><a href="#"><strong>Lorem ipsum</strong></a></li>
                        <li><a href="#"><strong>Lorem ipsum</strong></a></li>
                        <li><a href="#"><strong>Lorem ipsum</strong></a></li>
                        <li><a href="#"><strong>Lorem ipsum</strong></a></li>
                    </ul>
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
            <div class="col c1">
                <h2><span>Image Gallery</span></h2>
                <a href="#"><img src="/images/site/pix1.jpg" width="58" height="58" alt=""/></a> <a href="#"><img src="/images/site/pix2.jpg" width="58"
                                                                                                            height="58" alt=""/></a> <a href="#"><img
                    src="/images/site/pix3.jpg" width="58" height="58" alt=""/></a> <a href="#"><img src="/images/site/pix4.jpg" width="58" height="58"
                                                                                               alt=""/></a> <a href="#"><img src="/images/site/pix5.jpg"
                                                                                                                             width="58" height="58"
                                                                                                                             alt=""/></a> <a href="#"><img
                    src="/images/site/pix6.jpg" width="58" height="58" alt=""/></a></div>
            <div class="col c2">
                <h2><span>Lorem Ipsum</span></h2>

                <p>Lorem ipsum dolor<br/>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. <a href="#">Morbi
                        tincidunt, orci ac convallis aliquam</a>, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus
                    nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam.</p>
            </div>
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
            <p class="lf">&copy; Copyright <a href="#">MyWebSite</a>.</p>

            <p class="rf">Layout by Rocket <a href="http://www.rocketwebsitetemplates.com/">Website Templates</a></p>

            <div class="clr"></div>
        </div>
    </div>
</div>
</body>
</html>
