<?php build('page-control')?>
	<a href="<?php echo _route('service:index')?>" 
		class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-list fa-sm text-white-50"></i> Products </a>
<?php endbuild()?>

<?php build('content')?>	
	<div class="col-md-7">
		<?php Flash::show()?>
		
		<div class="card">
			<div class="card-body">
				<?php __( $form->start() )?>

					<div class="form-group">
						<?php
							__( $form->getRow('service') );
						?>
					</div>

					<div class="form-group">
						<?php
							__( $form->getRow('price') );
						?>
					</div>

					<div class="form-group">
						<?php
							__( $form->getRow('category_id') );
						?>
					</div>
					

					<div class="form-group">
						<?php
							__( $form->getRow('status') );
						?>
					</div>
					

					<div class="form-group">
						<?php
							__( $form->getRow('description') );
						?>
					</div>

					<div class="form-group">
						<?php
							__( $form->getRow('images[]') );
						?>
					</div>

					<div class="form-group">
						<?php
							__( $form->get('submit') );
						?>
					</div>
				<?php __( $form->end() )?>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>