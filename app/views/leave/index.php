<?php build('page-control')?>
<div class="widget widget-content-area page-command-container">
	<a href="<?php echo _route('leave:create', null)?>" 
		class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i data-feather="plus-circle"></i></a>
</div>
<?php endbuild()?>


<?php build('content') ?>
<div class="statbox widget box box-shadow">
    <div class="widget-header">
        <h4>Leave Management</h4>
    </div>
    <div class="widget-content widget-content-area">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>User</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Referene Date</th>
                    <th>Approved By</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php foreach($leaves as $key => $row) : ?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->user_full_name?></td>
                            <td><?php echo $row->start_date?></td>
                            <td><?php echo $row->end_date?></td>
                            <td><?php echo $row->status?></td>
                            <td><?php echo $row->leave_category?></td>
                            <td><?php echo $row->date_filed?></td>
                            <td><?php echo $row->approver_full_name?></td>
                            <td>
                                <?php echo wLinkDefault(_route('leave:edit', $row->id), '', [
                                    'icon' => 'edit'
                                ])?>
                                &nbsp;
                                <?php echo wLinkDefault(_route('leave:approve', $row->id), '', [
                                    'icon' => 'check-circle'
                                ])?>
                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>