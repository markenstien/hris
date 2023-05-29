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
            <?php echo $form->start()?>
                <?php echo $form->getFormItems('col')?>
                <div class="form-group mt-5">
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