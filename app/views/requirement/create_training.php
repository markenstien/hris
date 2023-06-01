
<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Create Traning & Seminars</h4>
            <?php echo wLinkDefault(_route('requirement:index'), 'Back to list', ['icon' => 'arrow-left-circle'])?>
        </div>
        <div class="widget-content widget-content-area">
            <?php echo $trainingForm->start()?>
                <?php echo $trainingForm->getFormItems()?>

                <?php
                    Form::hidden('department_select_all', 'on');
                    Form::hidden('position_select_all', 'on');
                ?>
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