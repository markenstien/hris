<?php build('content') ?>
<div class="row">
    <div class="col-md-5">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <h4 class="widget-title">File AC</h4>
            </div>

            <div class="widget-content widget-content-area">
                <?php __($form->start());?>
                    <?php __($form->get('user_id'))?>
                    <div class="form-group"><?php echo $form->getCol('start_date')?></div>
                    <div class="form-group"><?php echo $form->getCol('end_date')?></div>
                    <div class="form-group"><?php echo $form->getCol('sheet_category')?></div>
                    <div class="form-group"><?php echo $form->getCol('time_in')?></div>
                    <div class="form-group"><?php echo $form->getCol('time_out')?></div>
                    <div class="form-group"><?php echo $form->getCol('remarks')?></div>
                    <div class="form-group"><?php echo $form->getCol('submit')?></div>
                <?php __($form->end())?>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>