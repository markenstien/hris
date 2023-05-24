<?php build('content') ?>

    <div class='card'>
        <div class='card-header'>
            <h4 class='card-title'>Schedule Edit : <?php echo $user->firstname?></h4>
            <a href="/user/edit/<?php echo $user->id?>">Return</a>
            <?php Flash::show()?>
        </div>

        <div class='card-body'>
            <?php 
                Form::open([
                    'method' => 'post',
                    'action' => '/schedule/update'
                ]);

                Form::hidden('id' , $schedule->id);
            ?>

            <div class='form-group'>
                <?php
                    Form::label('Time In');
                    Form::time('time_in' , $schedule->time_in , [
                        'class' => 'form-control'
                    ]);
                ?>
            </div>
            <div class='form-group'>
                <?php
                    Form::label('Time Out');
                    Form::time('time_out' , $schedule->time_out , [
                        'class' => 'form-control'
                    ]);
                ?>
            </div>

            <div class='form-group'>
                <?php
                    Form::label('Rest Day');
                ?>
                <div>
                    <label for="r-off">
                        <?php
                            if($schedule->is_off) { 
                                Form::radio("is_off" , 1 , ['id' => "r-off", 'checked' => '']);
                            }else{
                                Form::radio("is_off" , 1 , ['id' => "r-off"]);
                            }
                        ?>
                        Rest Day
                    </label>
                    <label for="r-on">
                    <?php
                            if($schedule->is_off == false) { 
                                Form::radio("is_off" , 0 , ['id' => "r-on", 'checked' => '']);
                            }else{
                                Form::radio("is_off" , 0 , ['id' => "r-on"]);
                            }
                        ?>
                        Work Day
                    </label>
                </div>
            </div>

            <div class='form-group'>
                <?php Form::submit('' , 'Save Changes')?>
            </div>

            <?php Form::close()?>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo('tmp/layout')?>