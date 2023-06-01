<?php build('content') ?>
<div class="row">
    <div class="col-md-5">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <h4>Respondent View</h4>
                <?php echo wLinkDefault(_route('requirement:show',$training->id) , 'Back to view', ['icon' => 'arrow-left-circle'])?>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Answer Reference</td>
                            <td><?php echo $respondent->eerr_reference?></td>
                        </tr>
                        <tr>
                            <td>Training Title</td>
                            <td><?php echo wLinkDefault(_route('requirement:show', $training->id), $training->req_title, ['icon' => 'eye'])?></td>
                        </tr>
                        <tr>
                            <td>Respondent</td>
                            <td><?php echo $respondent->full_name?></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><?php echo $respondent->eerr_description?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><?php echo $respondent->eerr_status?></td>
                        </tr>
                        <?php if($respondent->approved_by) :?>
                        <tr>
                            <td>Approved By</td>
                            <td><?php echo $respondent->approver_name?></td>
                        </tr>

                        <tr>
                            <td>Approved Date</td>
                            <td><?php echo $respondent->approved_date?></td>
                        </tr>
                        <?php endif?>
                    </table> 
                </div>

                <?php
                    if(isManagement()) {
                        echo wLinkDefault(_route('requirement:approveRespond', $respondent->id), 'Approve', [
                            'icon' => 'check-circle',
                            'class' => 'btn btn-primary btn-sm mt-4'
                        ]);
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <h4>Files</h4>
            </div>
            <div class="widget-content widget-content-area">
                <?php foreach($attachments as $key => $row):?>
                    <a href="<?php echo _route('viewer:show', null, [
                        'file' => $row->full_url,
                    ])?>" target="_blank">
                        <div style="border:1px solid #000; padding:10px; display:inline-block; width:100%">
                            <i data-feather="file" style="width: 54px; height: 54px;"></i>
                            <p><?php echo crop_string($row->display_name, '20')?></p>
                        </div>
                    </a>
                <?php endforeach?>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>