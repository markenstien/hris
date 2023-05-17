<?php build('content')?>
<div class="col-md-8 mx-auto">
	<?php Flash::show()?>
	<div class="statbox widget box box-shadow">
		<div class="widget-header">
            <h4>Create new Position</h4>
            <?php echo wLinkDefault(_route('emp-attr:position'), 'Back to last', [
                'icon' => 'arrow-left-circle'
            ])?>
        </div>

		<div class="widget-content widget-content-area">
            <?php echo $eeAttrForm->start()?>
                <?php  echo $eeAttrForm->getCol('attr_key'); ?>
                <div class="formg-roup">
                    <?php
                        echo $eeAttrForm->getCol('attr_name',[
                            'label' => 'Position/Title'
                        ]) ?>
                </div>

                <div class="formg-roup">
                    <?php
                        echo $eeAttrForm->getCol('parent_id',[
                            'label' => 'Position Department'
                        ]) ?>
                </div>

                <div class="formg-roup">
                    <?php
                        echo $eeAttrForm->getCol('attr_abbr_name',[
                            'label' => 'Position/Title ABBR'
                        ]) ?>
                </div>

                <div class="formg-roup mt-4">
                    <?php Form::submit('', 'Create New Position') ?>
                </div>
            <?php echo $eeAttrForm->end()?>
		</div>
	</div>
</div>
<?php endbuild()?>
<?php loadTo()?>