<?php build('content') ?>
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Training Preview</h4>
            <?php echo wLinkDefault(_route('requirement:index'), 'Back to lists', ['icon' => 'arrow-left-circle'])?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <h4>Training/Seminar</h4>
                    <?php Flash::show()?>
                    <div class="text-center">
                        <a href="#" class="btn btn-primary btn-sm mb-3" 
                        data-toggle="modal" 
                        data-target=".trainingSubmissionModal">Submit Training</a>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td>Code</td>
                            <td><?php echo $training->req_code?></td>
                        </tr>
                        <tr>
                            <td>Training Title</td>
                            <td><?php echo $training->req_title?></td>
                        </tr>
                        <tr>
                            <td>Start Date</td>
                            <td><?php echo $training->start_date?></td>
                        </tr>
                        <tr>
                            <td>Deadline</td>
                            <td><?php echo $training->end_date?></td>
                        </tr>
                        <tr>
                            <td>Importance</td>
                            <td><?php echo $training->importance?></td>
                        </tr>
                    </table>
                    <p><?php echo $training->description?></p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <h4>Recipients</h4>
                    <div class="mt-5">
                        <h5>Departments</h5>
                        <?php if($training->is_all_department) :?>
                            <span class="badge badge-primary">All Department</span>
                        <?php else:?>
                            <?php foreach($training->recipients as $key => $row) :?>
                                <?php if(!isEqual($row->attr_key, 'department')) continue?>
                                <span style="text-decoration:underline"><?php echo $row->attr_name?> (<?php echo $row->attr_abbr_name?>)</span> ,
                            <?php endforeach?>
                        <?php endif?>
                    </div>

                    <div class="mt-5">
                        <h5>Positions</h5>
                        <?php if($training->is_all_position) :?>
                            <span class="badge badge-primary">All Positions</span>
                        <?php else:?>
                            <?php foreach($training->recipients as $key => $row) :?>
                                <?php if(!isEqual($row->attr_key, 'position')) continue?>
                                <span style="text-decoration:underline"><?php echo $row->attr_name?> (<?php echo $row->attr_abbr_name?>)</span> ,
                            <?php endforeach?>
                        <?php endif?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo wDivider('70')?>
    <div class="row">
        <div class="col-md-7">
            <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <h4>Respondents</h4>
                <!-- Images -->
                <ul class="list-group list-group-media">
                    <?php foreach($respondents as $key => $row) :?>
                        <li class="list-group-item list-group-item-action">
                            <div class="media">
                                <div class="mr-3">
                                    <img alt="avatar" src="<?php echo $row->profile ?? _path_tmp('assets/img/90x90.jpg')?>" class="img-fluid rounded-circle" style="width:50px">
                                </div>
                                <div class="media-body">
                                    <h6 class="tx-inverse"><?php echo $row->full_name?></h6>
                                    <p class="mg-b-0"><?php echo $row->position_name?></p>
                                    <?php echo wLinkDefault(_route('requirement:respondentView', $row->id), 'Show Respondent', ['icon' => 'eye'])?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach?>
                </ul>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade trainingSubmissionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleLargeModalLabel">Training Respondent Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $trainingSubmitForm->getForm()?>
                </div>
            </div>
        </div>
    </div>

<?php endbuild()?>
<?php loadTo()?>