<?php build('page-control')?>
	<div class="widget widget-content-area page-command-container">
		<a href="<?php echo _route('emp-attr:create', null,[
            'type'=> 'DEPARTMENT'
        ])?>" 
			class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i data-feather="user-plus"></i></a>
	</div>
<?php endbuild()?>

<?php build('content') ?>
<?php Flash::show()?>
<div class="statbox widget box box-shadow">
    <div class="widget-header">
        <h4>Departments</h4>
    </div>

    <div class="widget-content widget-content-area">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Acronym(abbr)</th>
                    <th>Department</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php foreach($departments as $key => $row) :?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->attr_abbr_name?></td>
                            <td><?php echo $row->attr_name?></td>
                            <td>
                                <?php echo wLinkDefault(_route('emp-attr:edit', $row->id, [
                                    'type' => 'DEPARTMENT'
                                ]), '', [
                                    'icon' => 'edit'
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