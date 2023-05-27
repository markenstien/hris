<?php build('content') ?>
<div class="col-md-6">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Leave Management</h4>
                <?php echo wLinkDefault(_route('leave:index'), 'Back to lists', [
                    'icon' => 'arrow-left-circle'
                ]);
            ?>
        </div>
        <div class="widget-content widget-content-area">
            <?php Flash::show()?>
            <?php echo $form->getForm('col')?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>