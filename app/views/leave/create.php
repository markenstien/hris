<?php build('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <h4>Leave Request</h4>
                    <?php echo wLinkDefault(_route('leave:index'), 'Back to lists', [
                        'icon' => 'arrow-left-circle'
                    ]);
                ?>
            </div>
            <div class="widget-content widget-content-area">
                <?php Flash::show()?>
                    <?php echo $form->start()?>
                        <?php echo $form->getCol('user_id', [
                            'value' => whoIs('id')
                        ])?>
                        <?php echo $form->getCol('leave_category')?>
                        <?php echo $form->getCol('date_filed')?>
                        <?php echo $form->getCol('start_date')?>
                        <?php echo $form->getCol('end_date')?>

                        <div class="mt-2"><?php Form::submit('', 'Save Leave Request')?></div>
                    <?php echo $form->end()?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <h4>Leave Point Reference</h4>
            </div>
            <div class="widget-content widget-content-area">
                <?php foreach($leavePoint as $key => $row) :?>
                <h4><?php echo $row->leave_point_category . " : " .$row->total_point?></h4>
            <?php endforeach?>
            </div>
        </div>
    </div>
    
</div>
<?php endbuild()?>
<?php loadTo()?>