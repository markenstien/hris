<?php build('page-control')?>
    <?php if(isHR()) :?>
        <div class="widget widget-content-area page-command-container">
            <?php echo wLinkDefault(_route('requirement:create'), '', ['icon' => 'plus-circle','class' => 'btn btn-secondary btn-sm'])?>
        </div>
    <?php endif?>
<?php endbuild()?>

<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Create Traning & Seminars</h4>
            <?php echo wLinkDefault(_route('requirement:index'), 'Back to list', ['icon' => 'arrow-left-circle'])?>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                        <th>#</th>
                        <!-- <th>Code</th> -->
                        <th>Training</th>
                        <th>Description</th>
                        <th>Importance</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($requirements as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <!-- <td><?php echo $row->req_code?></td> -->
                                <td><?php echo $row->req_title?></td>
                                <td><?php echo crop_string($row->description, 100)?></td>
                                <td><?php echo $row->importance?></td>
                                <td><?php echo wLinkDefault(_route('requirement:show', $row->id), '', ['icon' => 'eye'])?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>