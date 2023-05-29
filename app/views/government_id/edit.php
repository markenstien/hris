<?php build('content')?>
<div class="col-md-8 mx-auto">
	<?php Flash::show()?>
	<div class="statbox widget box box-shadow">
		<div class="widget-header">
			<div class="row">
				<div class="col-xl-12 col-md-12 col-sm-12 col-12">
					<h4>Gonverment ID Details</h4>
                    <?php echo wLinkDefault(_route('user:show', $userId), '',[
                        'icon' => 'arrow-left-circle'
                    ])?>
				</div>
			</div>
		</div>

		<div class="widget-content widget-content-area">
            <?php
                $check = '<i data-feather="check-circle" class="text-success" title="verified"></i>';
                $unchecked = '<i data-feather="x-circle" class="text-danger" title="un-verified"></i>';
            ?>
            <?php foreach($governmentIds as $key => $row) :?>
                <form method="post">
                    <?php Form::hidden('id', $row->id)?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><?php echo $row->organization?></div>
                            <div class="col-md-4">
                                <?php if($row->is_verified) :?>
                                    <?php Form::text('id_number', $row->id_number, ['class' => 'form-control', 'required' => true, 'readonly' => true])?>
                                <?php else:?>
                                    <?php Form::text('id_number', $row->id_number, ['class' => 'form-control', 'required' => true])?>
                                <?php endif?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $row->is_verified ? $check:$unchecked?>
                            </div>
                            <div class="col-md-3">
                                <?php Form::submit('btn_update_org', 'Save')?>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endforeach?>
			<div class="form-group">

            </div>
		</div>

	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>