<?php build('content')?>
    <div class="container">
        <?php Flash::show()?>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">#<?php echo $bill->reference?></h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Payment</td>
                            <td><?php echo $bill->payment_status?>(<?php echo $bill->payment_method?>)</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td><?php echo amountHTML($bill->total_amount)?></td>
                        </tr>

                        <?php if( isset($bill->appointment) ): ?>
                            <tr>
                                <td>Appointment Ref</td>
                                <td><?php echo $bill->appointment->reference?></td>
                            </tr>
                        <?php endif?>
                    </table>
                </div>

                <h4>
                    <?php echo $bill->bill_to_name?>
                    <input type="hidden" name=" <?php echo $bill->bill_to_name?>" id="id_billed_to_name">
                </h4>
                <dl>
                    <dd><?php echo $bill->bill_to_email?></dd>
                    <input type="hidden" name=" <?php echo $bill->bill_to_email?>" id="id_billed_to_email">
                </dl>

                <section>
                    <strong>Services Availed</strong>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                            </thead>

                            <tbody>
                                <?php foreach($bill->items as $key => $item) :?>
                                    <tr>
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo $item->name?></td>
                                        <td><?php echo $item->description?></td>
                                        <td><?php echo amountHTML($item->price)?></td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>

                    <h6>Total Amount: <input type="text" name="total_amount" id="total_amount" 
                        value="<?php echo $bill->total_amount?>" 
                        disabled readonly> </h6>

                    <input type="hidden" name="" id="bill_id" value="<?php echo $bill->id?>">
                    <input type="hidden" name="" id="user_id" value="<?php echo whoIs('id')?>">
                    <input type="hidden" name="" id="method" value="online">

                </section>
            </div>

            <div class="card-footer">
                <?php if( isEqual($bill->payment_status, 'unpaid') ) :?>
                     <div id="paypal-button-container"></div>
                <?php endif?>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts')?>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo Module::get('thirdparty')['paypal']['client_id']?>&currency=PHP"></script>
    <script src="<?php echo _path_public('js/payment/payment.js')?>" defer></script>
<?php endbuild()?>

<?php loadTo('tmp/base')?>