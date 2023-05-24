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
                    <div class="form-group"><?php echo $form->getCol('time_in')?></div>
                    <div class="form-group"><?php echo $form->getCol('time_out')?></div>
                    <div class="form-group"><?php echo $form->getCol('remarks')?></div>
                    <div class="form-group"><?php echo $form->getCol('submit')?></div>
                <?php __($form->end())?>
            </div>

            <!-- <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </thead>

                        <tbody>
                            <?php foreach($timesheets as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->time_in?></td>
                                    <td><?php echo $row->time_out?></td>
                                    <td><?php echo date('Y-m-d', strtotime($row->time_in))?></td>
                                    <td><?php echo amountHTML($row->amount)?></td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div> -->

        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>