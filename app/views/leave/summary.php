<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="text-center">
                <h4>Leave Summary</h4>
                <p>For year <?php echo date('Y')?> as of <?php echo date('Y-m-d h:i:s A')?></p>

                <?php echo wDivider()?>

                <?php echo wLinkDefault(_route('leave:index'), 'Back to list', ['icon' => 'arrow-left-circle', 'class' => 'noprint'])?> &nbsp
                <?php echo wLinkDefault('javascript:void(0)', 'Print', ['icon' => 'printer','onclick' => 'window.print()', 'class' => 'noprint'])?>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <?php $leaveCategories = Module::get('ee_leave')['categories'] ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2" >Employee Data</td>
                        <td colspan="<?php echo count($leaveCategories)?>" style="text-align:center">Leave Summary</td>
                    </tr>
                    <tr>
                        <td style="background-color:var(--primary);color:#eee">Employee Name</td>
                        <td style="background-color:var(--primary);color:#eee">Employee ID</td>
                        <?php foreach($leaveCategories as $key => $row) :?>
                        <td style="background-color:var(--danger);color:#eee"><?php echo $row?></td>
                        <?php endforeach?>
                    </tr>

                    <?php foreach($summary as $key => $row) :?>
                        <?php $leavePointSummary = $row['leavePointSummary']?>
                        <tr>
                            <td><?php echo $row['user']->full_name?></td>
                            <td><?php echo wLinkDefault(_route('user:show', $row['user']->id), $row['user']->user_code)?></td>
                            <?php foreach($leaveCategories as $key => $row) :?>
                                <td><?php echo isset($leavePointSummary[$row]) ? "<span class='badge badge-info'>{$leavePointSummary[$row]}</span>" : '0'?></td>
                            <?php endforeach?>

                            
                        </tr>
                    <?php endforeach?>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>