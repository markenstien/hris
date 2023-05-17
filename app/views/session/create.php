<?php build('content') ?>
	
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Patient Session</h4>
		</div>

		<div class="card-body">
			<?php
				__($form->getForm());
			?>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>