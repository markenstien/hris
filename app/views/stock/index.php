<?php build('content')?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Stocks</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Sku</th>
                        <th>Name</th>
                        <th>Stocks</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach ($stocks as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->code?></td>
                                <td><?php echo $row->service?></td>
                                <td><?php echo $row->total_stock?></td>
                                <td>
                                    <a href="<?php echo _route('stock:create',null,[
                                        'csrfToken' => csrfGet(),
                                        'item_id'   => $row->id
                                    ])?>">Manage Stock</a> | 

                                    <a href="<?php echo _route('stock:log',null,[
                                        'item_id' => $row->id
                                    ])?>">Logs</a>
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