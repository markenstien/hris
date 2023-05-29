
<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Create Traning</h4>
            <?php echo wLinkDefault(_route('requirement:index'), 'Back to list', ['icon' => 'arrow-left-circle'])?>
        </div>
        <div class="widget-content widget-content-area">
            <?php echo $trainingForm->start()?>
                <?php echo $trainingForm->getFormItems()?>

            <div class="form-group">
                <div class='row mb-2'>
                    <div class='col-md-3'>
                        Departments
                        <div>
                            <label for="department_select_all">
                                <input type="checkbox" id="department_select_all" name="department_select_all">
                                Select All
                            </label>
                        </div>
                    </div>
                    <div class='col-md-9'>
                        <?php foreach($departments as $key => $row) :?>
                            <label for="department<?php echo $row->id?>" class="input-box">
                                <?php echo $row->attr_name . "({$row->attr_abbr_name})"?>
                                <input type="checkbox" 
                                id="department<?php echo $row->id?>" 
                                name="departments[]" 
                                class="department"
                                value="<?php echo $row->id?>">
                            </label>
                        <?php endforeach?>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class='row mb-2'>
                    <div class='col-md-3'>
                        Positions
                        <div>
                            <label for="position_select_all">
                                <input type="checkbox" id="position_select_all" name="position_select_all">
                                Select All
                            </label>
                        </div>
                    </div>
                    <div class='col-md-9'>
                        <?php foreach($positions as $key => $row) :?>
                            <label for="position<?php echo $row->id?>" class="input-box">
                                <?php echo $row->attr_name . "({$row->attr_abbr_name})"?>
                                <input type="checkbox" 
                                id="position<?php echo $row->id?>" 
                                name="positions[]" 
                                class="position"
                                value="<?php echo $row->id?>">
                            </label>
                        <?php endforeach?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php Form::submit('', 'Create Training')?>
            </div>

            <?php echo $trainingForm->end()?>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts')?>
    <script>
        $(document).ready(function() {
            let positionSelectAll = $('#position_select_all');
            let departmentSelectAll = $('#department_select_all');

            $("#position_select_all").click(function(){
                if($(this).is(':checked')) {
                    $('.position').prop('checked', true);
                } else {
                    $('.position').prop('checked', false);
                }
            });

            $("#department_select_all").click(function(){
                if($(this).is(':checked')) {
                    $('.department').prop('checked', true);
                } else {
                    $('.department').prop('checked', false);
                }
            });

            $('.department').click(function(){
                if($(this).is(':checked') == false) {
                    $('#department_select_all').prop('checked',false);
                }
            });

            $('.position').click(function(){
                if($(this).is(':checked') == false) {
                    $('#position_select_all').prop('checked',false);
                }
            })
        });
    </script>
<?php endbuild()?>
<?php loadTo()?>