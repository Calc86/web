<?php /* @var $this Controller */ ?>

<!DOCTYPE html>
<html>
<head>
    <meta HTTP-EQUIV="Content-Type" Content="text-html; charset=utf-8">
    <meta name="language" content="ru" />

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" rel="stylesheet" type="text/css">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php //<!-- for video tag --> ?>
    <script src="<?php echo Yii::app()->baseUrl; ?>/mediaelement/build/mediaelement-and-player.min.js"></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/mediaelement/build/mediaelementplayer.css" />

</head>

<body>

<!-- LAYOUT -->
<?php echo $content; ?>
<!-- /LAYOUT -->


</body>
</html>

