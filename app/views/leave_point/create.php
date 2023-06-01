<?php build('content') ?>
<div class="col-md-5 mx-auto">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Manage Leave Credits</h4>
        </div>
        <div class="widget-content widget-content-area">
            <?php echo $form->start()?>
                <?php echo $form->getCol('leave_point_category')?>
                <?php echo $form->getCol('user_id')?>
                <div class="row">
                    <div class="col">
                        <?php echo $form->getCol('point')?>
                    </div>
                    <div class="col">
                        <?php echo $form->getCol('point_type')?>
                    </div>
                </div>
                <?php echo $form->getCol('remarks')?>

                <div class="mt-2"><?php Form::submit('', 'Save Point Entry')?></div>
            <?php echo $form->end()?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>