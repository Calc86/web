<?php
/* @var $this SiteController */

/* $main = array of blocks*/

/*$this->breadcrumbs=array(
	'Themes'=>array('/themes'),
	'Main',
);*/

$this->layout = 'column0';

?>

<div class="container">
    <div class="span-2">&nbsp;</div>
    <div class="span-14 white_box">
        <div class="span-7">
            <div class="cols">
                <h1><?=$main['main_col1']->title;?></h1>
                <p>
                    <?=$main['main_col1']->text;?>
                </p>
                <p class="button"><a href='#' class='button'>Подробнее</a></p>
            </div>
        </div>
        <div class="span-7 last">
            <div class="cols">
                <h1><?=$main['main_col2']->title;?></h1>
                <p>
                    <?=$main['main_col2']->text;?>
                </p>
                <p class="button"><a href='#' class='button'>Подробнее</a></p>
            </div>
        </div>
    </div>
    <div class="span-12 last text">
        <h1><?=$main['main_col3']->title;?></h1>
        <p>
            <?=$main['main_col3']->text;?>
        </p>
    </div>
</div>

<div class="tarifs white_box container">
    <!--<div class="span-6 tarif">
        <a href="#" class="button3">Бесплатный</a>
        <span class="cost">0</span><span>р/мес.</span>
        <p>2 камеры</p>
        <p>Без записи</p>
        <p>Онлайн просморт</p>
        <br/>
    </div>
    <div class="span-6 tarif">
        <a href="#" class="button3">Пробный</a>
        <span class="cost">100</span><span>р/мес.</span>
        <p>2 камеры</p>
        <p>Без записи</p>
        <p>Онлайн просморт</p>
        <br/>
    </div>
    <div class="span-6 tarif">
        <a href="#" class="button3">Наблюдатель</a>
        <span class="cost">300</span><span>р/мес.</span>
        <p>2 камеры</p>
        <p>Без записи</p>
        <p>Онлайн просморт</p>
        <br/>
    </div>
    <div class="span-6 tarif">
        <a href="#" class="button3">Охрана</a>
        <span class="cost">600</span><span>р/мес.</span>
        <p>2 камеры</p>
        <p>Без записи</p>
        <p>Онлайн просморт</p>
        <br/>
    </div>
    <div class="span-6 last tarif">
        <a href="#" class="button3">Большой брат</a>
        <span class="cost">2 600</span><span>р/мес.</span>
        <p>2 камеры</p>
        <p>Без записи</p>
        <p>Онлайн просморт</p>
        <br/>
    </div>-->
    <div class="span-6 last tarif">
        <a href="#" class="button3">Тариф</a>
        <span class="cost">300</span><span>р/мес.</span>
        <p>1 камера</p>
        <p>Постоянная запись</p>
        <p>Облачное хранилище записей</p>
        <p>Онлайн просмотр</p>
        <p>Возможность скачивания архива</p>
        <p>Техническая поддержка</p>
        <br/>
    </div>
</div>