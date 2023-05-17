<?php build('content')?>
	<div class="container">
		<?php Flash::show()?>
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Service Items</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<?php $discount = 0?>
							<?php if($cart_items) :?>
								<table class="table table-bordered">
									<thead>
										<th>Service</th>
										<th>Amount</th>
										<th>Action</th>
									</thead>

									<tbody>
										<?php
											$lastItem = 'bundle';
										?>
										<?php foreach( $cart_items as $key => $cart) :?>
											<?php
												if( isEqual($cart['type'] , 'bundle'))
												{
													$discount += $cart['bundle']->discount;
													?> 
														<tr style="background: green; color: #fff;">
															<td><?php echo $cart['bundle']->name?></td>
															<td>
																<?php if( $cart['bundle']->discount ) :?>
																	<?php echo number_format($cart['bundle']->public_price - $cart['bundle']->discount , 2)?>
																	<s><?php echo $cart['bundle']->public_price?></s>
																<?php endif?>
															</td>
															<td>
																<a href="<?php echo _route('service-cart:delete' , $cart['id'])?>" style="color:#fff"> <i class="fa fa-trash"></i> Remove Item</a>
															</td>
														</tr>
													<?php
													$lastItem = 'bundle';
													foreach($cart['items'] as $cartKey => $cartI) 
													{
														?> 
														<tr>
															<td><?php echo $cartI->service?></td>
															<td>---</td>
															<td>---</td>
														</tr>
														<?php
													}
												}else
												{
													if( $lastItem == 'bundle' ) 
													{
														?>
															<tr>
																<td colspan="3"></td>
															</tr>
														<?php
													}
													?>
														<tr>
															<td><?php echo $cart['item']->service?></td>
															<td><?php echo $cart['item']->price?></td>
															<td>
																<a href="<?php echo _route('service-cart:delete' , $cart['id'])?>"> 
																<i class="fa fa-trash"></i> Remove Item</a>
															</td>
														</tr>
													<?php
													$lastItem = 'service';
												}
											?>
										<?php endforeach?>
									</tbody>
								</table>

								<h5>Total : <?php echo amountHTML($cart_item_summary['total_amount'] - $discount)?></h5>
							<?php else:?>
								<h5>No Services Selected  <a href="<?php echo _route('appointment:create')?>">Add One Now</a></h5>
							<?php endif?>
						</div>	
					</div>
				</div>
			</div>


			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Checkout Page</h4>
					</div>

					<div class="card-body">
						<?php if(!$auth || isEqual($auth->user_type , 'patient')) :?>
							<?php __( [$form->start() ] )?>

							<?php __( $form->get('discount')) ?>

								<?php
									if($auth){
										$form->add(['type' => 'hidden' , 'value' => $auth->id , 'name' => 'user_id']);
										__( $form->get('user_id') );


										$full_name = $auth->first_name . ' ' . $auth->last_name;
										$email = $auth->email;
										$phone_number = $auth->phone_number;
									}
									
								?>
								<div class="form-group">
									<?php
										__( $form->getRow('date',['value' => date('Y-m-d') ]));
									?>
								</div>

								<div class="form-group">
									<?php
										__( $form->getRow('start_time',['value' => date('h:i:s') ]));
									?>
								</div>

								<div class="form-group">
									<?php
										$form->setValue('guest_name' , $full_name ?? '');
										__( $form->getRow('guest_name'));
									?>
								</div>

								<div class="form-group">
									<?php
										$form->setValue('guest_email' , $email ?? '');
										__( $form->getRow('guest_email'));
									?>
								</div>

								<div class="form-group">
									<?php
										$form->setValue('guest_phone' , $phone_number ?? '');
										__( $form->getRow('guest_phone'));
									?>
								</div>

								<div>
									<?php __( $form->get('submit' , ['value' => 'Create Appointment'])) ?>
								</div>

							<?php __( $form->end() )?>

						<?php else:?>
							<?php
								$form->setValue('date' , date('Y-m-d'));
								$form->setValue('type' , 'walk-in');

								__( $form->getForm() );
							?>
						<?php endif?>
					</div>
				</div>
			</div>
		</div>		
	</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>