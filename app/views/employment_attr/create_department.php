<?php build('content')?>
<div class="col-md-8 mx-auto">
	<?php Flash::show()?>
	<div class="statbox widget box box-shadow">
		<div class="widget-header">
            <h4>Create new Department</h4>
            <?php echo wLinkDefault(_route('emp-attr:department'), 'Back to last', [
                'icon' => 'arrow-left-circle'
            ])?>
        </div>

		<div class="widget-content widget-content-area">
            <?php echo $eeAttrForm->start()?>
                <?php  echo $eeAttrForm->getCol('attr_key'); ?>
                <div class="formg-roup">
                    <?php
                        echo $eeAttrForm->getCol('attr_name',[
                            'label' => 'Department Name'
                        ]) ?>
                </div>

                <div class="formg-roup">
                    <?php
                        echo $eeAttrForm->getCol('attr_abbr_name',[
                            'label' => 'Department Name ABBR'
                        ]) ?>
                </div>

                <div class="formg-roup mt-4">
                    <?php Form::submit('', 'Create New Department') ?>
                </div>
            <?php echo $eeAttrForm->end()?>
		</div>

	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>