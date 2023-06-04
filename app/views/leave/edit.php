<?php build('content') ?>
<div class="col-md-6">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Edit Leave Request</h4>
            <?php echo wLinkDefault(_route('leave:index'), 'Back to lists', [
                'icon' => 'arrow-left-circle'
            ]);
            ?>
        </div>
        <div class="widget-content widget-content-area">
            <?php echo $form->start()?>
                <?php 
                    echo $form->getCol('id');
                    echo $form->getCol('user_id');
                ?>
                <?php echo $form->getCol('leave_category')?>
                <?php echo $form->getCol('date_filed')?>
                <?php echo $form->getCol('start_date')?>
                <?php echo $form->getCol('end_date')?>

                
                <div class="mt-2">
                    <?php Form::submit('', 'Save Leave Request')?>

                    <?php echo wLinkDefault(_route('leave:delete', $leave->id,[
                        'route' => seal(_route('leave:index'))
                    ]), 'Delete', [
                        'icon' =>  'trash-circle',
                        'class' => 'btn btn-danger btn-sm form-verify'
                    ])?>
                </div>

            <?php echo $form->end()?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>