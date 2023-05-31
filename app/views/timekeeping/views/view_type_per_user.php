
<?php extract($data)?>
<?php $startDateIncreasing = request()->input('start_date')?>

<h4 class="text-center">Timesheet</h4>
<div class="table-responsive">
    <table class="table-bordered table <?php echo isAdmin() ? 'dataTableAction' : ''?>" style="text-align:left">
        <thead>
            <td>Employee</td>
            <td>Summary</td>
            <?php while($startDateIncreasing <= request()->input('end_date')) :?>
                <td><?php echo $startDateIncreasing?></td>
                <?php $startDateIncreasing = date('Y-m-d', strtotime('+1 day'.$startDateIncreasing))?>
            <?php endwhile?>
            
            <?php $startDateIncreasing = request()->input('start_date'); //reset?>
        </thead>

        <tbody>
            <?php foreach($usersTimesheets as $key => $row) :?>
                <?php
                    $uTimeSheetsArray = $row['timesheets'];
                    $timesheetDates = array_keys($uTimeSheetsArray);  
                ?>
                <tr>
                    <td><?php echo $row['user']['full_name']?></td>
                    <td>
                        <ul class="list-style-none">
                            <div>Present : <?php echo $row['present']?></div>
                            <div>Absent : <?php echo $row['absent']?></div>
                        </ul>
                    </td>
                    <?php while($startDateIncreasing <= request()->input('end_date')) :?>
                    <td>
                        <?php
                                if(isEqual($startDateIncreasing, $timesheetDates)) {
                                    echo '<span class="badge badge-primary">present</span>';
                                }else{
                                    echo '<span class="badge badge-danger">absent</span>';
                                }
                            ?>
                    </td>
                        <?php $startDateIncreasing = date('Y-m-d', strtotime('+1 day'.$startDateIncreasing))?>
                    <?php endwhile?>
                    <?php $startDateIncreasing = request()->input('start_date'); //reset?>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>