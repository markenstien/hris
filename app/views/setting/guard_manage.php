<?php build('content') ?>
<div class="col-md-5 mx-auto">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Guard Settings</h4>
        </div>

        <div class="card-body">
            <?php
                Flash::show();
                Form::open(['method' => 'post']);
                Form::hidden('id', $guard_data->id);
            ?>
                <div class="form-group">
                    <?php
                        Form::label('Username');
                        Form::text('meta_key', $guard_data->meta_key, [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php
                        Form::label('Password');
                        Form::password('meta_value','', [
                            'class' => 'form-control',
                            'required' => true
                        ])
                    ?>
                </div>

                <div class="form-group">
                    <?php Form::submit('', 'Save Changes')?>
                </div>
            <?php Form::close()?>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>