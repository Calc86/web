<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<table id="layout">
    <tr>
        <?php $this->renderPartial('/default/menu'); ?>
        <td id="content">
            <!-- MAIN BLOCK START -->
            <div id="main">
                <div class="content">
                    <div class="logo_small">
                        <a href="<?=$this->createUrl("/cam")?>" class="img">
                            &nbsp;
                        </a>
                    </div>
                    <div style="height: 90px;" class="">
                        <!-- Какое то еще меню -->
                    </div>
                    <div class="columns">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
            <!-- MAIN BLOCK END -->
        </td>
    </tr>
</table>

<?php $this->endContent(); ?>