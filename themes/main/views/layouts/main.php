<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div class="container">
        <div class="logo_line">
            <div class="span-8">
                &nbsp;
            </div>
            <div class="span-20 append-2 last menu_line">
                <div id="mainmenu">
                    <?php

                    $this->widget('zii.widgets.CMenu',array(
                        'items'=>array(
                            array('label'=>'Home', 'url'=>array('/site/index')),
                            array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                            array('label'=>'Contact', 'url'=>array('/site/contact')),
                            array('label'=>'Login', 'url'=>array('/site/login', '#'=>'login'), 'visible'=>Yii::app()->user->isGuest),
                            array('label'=>'Видеонаблюдение', 'url'=>array('/cam'), 'visible'=>Yii::app()->user->checkAccess('user')),
                            //array('label'=>'Профиль', 'url'=>array('user/view','id'=>Yii::app()->user->id), 'visible'=>Yii::app()->user->checkAccess('user')),
                            array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                            array('label'=>'Admin:', 'visible'=>Yii::app()->user->checkAccess('moderator')),
                            array('label'=>'Pages', 'url'=>array('/Pages/index'), 'visible'=>Yii::app()->user->checkAccess('moderator')),
                            array('label'=>'Vendors', 'url'=>array('/camType/index'), 'visible'=>Yii::app()->user->checkAccess('admin')),
                            array('label'=>'Types', 'url'=>array('/camVendor/index'), 'visible'=>Yii::app()->user->checkAccess('admin')),
                            array('label'=>'Users', 'url'=>array('/user'), 'visible'=>Yii::app()->user->checkAccess('admin')),
                            array('label'=>'install roles', 'url'=>array('Roles'), 'visible'=>Yii::app()->user->checkAccess('admin')),
                        ),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="head_line1 line">
            <div class="span-30 last">
                &nbsp;
            </div>
        </div>
        <div class="head_line2 line">
            <div class="span-30 last logo">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/logo.png" />
            </div>
        </div>
        <div class="head_line3 line">
            <div class="prepend-2 span-10 header">
                <?php $main = Pages::main_block();?>
                <h1><?=$main->title;?></h1>
                <P><?=$main->text;?></P>
                <p class="button2"><a href='#' class='button2'>Прочитать</a></p>
            </div>
            <div class="span-18 append-bottom last cam">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/cam.png" />
            </div>
        </div>

        <!--content -->

        <?php echo $content; ?>

        <div class="clear"></div>
        <div class="container footer line">
            <div class="span-2">&nbsp;</div>
            <div class="span-6"><h1>Возможности</h1></div>
            <div class="span-6"><h1>Быстрая навигация</h1></div>
            <div class="span-2">&nbsp;</div>
            <div class="span-12"><h1>О сервисе</h1>
                <p>Я мог бы сказать, что еще ни о чем не думал, что просто рад быть на свободе, жить, снова видеть… наконец, что я уже сыт всем этим по горло и больше не строю планов… И он понял бы, что я лгу. Ведь он прекрасно знал меня. Поэтому я ответил
                    Я сумел сохранить на лице равнодушие. Значит, отец являлся не только мне. И открывать свои впечатления от нашей последней встречи я просто не вправе — они могли сойти за ханжество, приспособленчество и прямую ложь. Ведь тогда, пять лет назад, Оберон велел мне занять трон… Конечно, он имел в виду просто регентство.</p>
            </div>

            <div class="span-30"><h1 class="copyright">Copyright &copy; <?php echo (date('Y')=='2013' ? '2013' : '2013 — '.date('Y'));?> by My Company.</h1></div>

        </div>
    </div>
</body>
</html>
