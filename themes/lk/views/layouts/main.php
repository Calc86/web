<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html>
<head>
    <meta HTTP-EQUIV="Content-Type" Content="text-html; charset=utf-8">
    <meta name="language" content="ru" />

    <link href="<?php echo WebYii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo WebYii::app()->theme->baseUrl; ?>/css/form.css" rel="stylesheet" type="text/css">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>

<!-- LAYOUT -->
<?php echo $content; ?>
<!-- /LAYOUT -->


</body>
</html>

