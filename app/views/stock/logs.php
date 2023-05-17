<?php build('content') ?>
    
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Logs</h4>
            <?php Flash::show()?>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Quantity</th>
                        <th>Remarks</th>
                        <th>Origin</th>
                        <th>Date Time</th>
                    </thead>

                    <tbody>
                        <?php foreach($logs as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo amountHTML($row->quantity) ?></td>
                                <td><?php echo $row->remarks?></td>
                                <td><?php echo $row->entry_origin?></td>
                                <td><?php echo $row->created_at?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>