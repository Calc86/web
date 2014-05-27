<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<table id="layout">
    <tr>
        <td id="content">
            <!-- MAIN BLOCK START -->
            <div id="main">
                <div class="content">
                    <?php echo $content; ?>
                </div>
            </div>
            <!-- MAIN BLOCK END -->
        </td>
    </tr>
</table>

<?php $this->endContent(); ?>