<?php build('content')?>
    <div class="row">
        <div class="col-md-4">
            <div class="user-profile layout-spacing">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Personal</h3>
                        <a href="<?php echo _route('user:edit', $employment->user_id)?>" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                    </div>
                    <div class="text-center user-info">
                        <img src="<?php echo $user->profile ?? _path_tmp('assets/img/90x90.jpg')?>" alt="avatar" style="width:200px">
                        <p class=""><?php echo $employment->first_name . ' ' . $employment->last_name?></p>
                        <div><i data-feather="coffee"></i> <?php echo $employment->position_name?></div>
                    </div>
                </div>
            </div>

            <div class="statbox widget box box-shadow mb-2">
                <div class="widget-header">
                    <h4>Employment Details</h4>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><?php echo $employmentForm->getLabel('department_id')?></td>
                                <td><?php echo $employment->department_name?></td>
                            </tr>
                            <tr>
                                <td><?php echo $employmentForm->getLabel('reports_to')?></td>
                                <td><?php echo $employment->manager_name?></td>
                            </tr>
                            <tr>
                                <td><?php echo $employmentForm->getLabel('position_id')?></td>
                                <td><?php echo $employment->position_name?></td>
                            </tr>
                            <tr>
                                <td><?php echo $employmentForm->getLabel('employment_date')?></td>
                                <td><?php echo $employment->employment_date?></td>
                            </tr>
                            <tr>
                                <td><?php echo $employmentForm->getLabel('employment_status')?></td>
                                <td><?php echo $employment->employment_status?></td>
                            </tr>
                            <tr>
                                <td><?php echo $employmentForm->getLabel('salary_per_month')?></td>
                                <td><a href="#"><span data-content="<?php echo seal($employment->salary_per_month)?>">Double click to show</span></a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <h4>Schedule</h4>
                </div>

                <div class="widget-content widget-content-area">
                    <?php if(!$schedule) :?>
                        <?php echo wLinkDefault(_route('schedule:create', null, ['user_id' => $user->id]), 'Create Schedule')?>
                    <?php else:?>
                        <table class="table table-bordered">
                            <thead>
                                <th>Day</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Rest Day</th>
                            </thead>

                            <tbody>
                                <?php $schedTodayId = $scheduleToday->id?>
                                <?php foreach($schedule as $key => $row) :?>
                                    <tr <?php echo isEqual($schedTodayId , $row->id) ? "style='background:var(--success)'" : '' ?>>
                                        <td><?php echo $row->day?></td>
                                        <td><?php echo date_long($row->time_in , 'h:i:s A')?></td>
                                        <td><?php echo date_long($row->time_out , 'h:i:s A')?></td>
                                        <td>
                                            <?php if($row->is_off) :?>
                                                <span class="badge badge-danger"> RD </span>
                                            <?php else:?>
                                                <span class="badge badge-primary"> WD </span>
                                            <?php endif?>
                                        </td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    <?php endif?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="statbox widget box box-shadow mb-3">
                <div class="widget-header">
                    <h4>Performance Evaluation</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <h4>Underconstruction</h4>
                </div>
            </div>

            <div class="statbox widget box box-shadow mb-3">
                <div class="widget-header">
                    <h4>Files</h4>
                    <div style="padding: 15px;">
                        <?php wFileUploadForm($employment->user_id, 'EMPLOYEE_FILE', _route('file:upload'), null , $_GET['folder'] ?? null)?>
                        <?php wFolderAddForm($employment->user_id, 'EMPLOYEE_FILE', _route('folder:create'), null , $_GET['folder'] ?? null)?>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <?php echo wDivider(70)?>
                    <section id="gallerySection">
                        <?php Flash::show('folderAlert')?>
                        <?php if(isset($folderFilesAndFolders) ) :?>
                            <section class="section">
                                <?php if($folderFilesAndFolders->parent_id) :?>
                                    <?php echo wLinkDefault(_route('user:show', $user->id, [
                                        'page' => 'files',
                                        'folder' => $folderFilesAndFolders->parent_id
                                    ]), 'Last Oflder', [
                                        'icon' => 'arrow-left-circle'
                                    ])?>

                                    <?php echo wDivider(50)?>
                                <?php endif?>
                                <h4>Photos</h4>
                                <div class="row">
                                    <!-- files -->
                                    <?php foreach($folderFilesAndFolders->files as $fileKey => $file) :?>
                                        <?php
                                            $fileName = $file->name;
                                            $ext = explode('.' , $fileName);
                                            $ext = end($ext);
                                        ?>
                                        <?php if( isEqual( $ext , ['png','gif','jpeg' , 'jpg']) ) :?>
                                            <div class="col-lg-3 col-md-4 col-xs-6 thumb hover-show-delete mb-3">
                                                <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="<?php echo $file->display_name?>"
                                                data-image="<?php echo $file->url.'/'.$fileName?>"
                                                data-target="#image-gallery">
                                                    <img class="img-thumbnail"
                                                        src="<?php echo $file->url.'/'.$fileName?>"
                                                        alt="Another alt text" style="height: 150px;">
                                                </a>

                                                <div class="hidden-delete-button">
                                                    <a href="<?php echo _route('file:delete' , $file->id)?>" style="text-decoration: underline;">Delete</a>
                                                </div>
                                            </div>
                                        <?php endif?>
                                    <?php endforeach?>
                                </div>
                            </section>
                            <section class="section">
                                <h4>Folders</h4>
                                <div class="row">
                                    <!-- files -->
                                    <?php foreach($folderFilesAndFolders->folders as $folderKey => $folder) :?>
                                        <div class="col-md-4">
                                            <a href="?page=files&folder=<?php echo $folder->id?>" style="text-decoration:underline">
                                                <i class="feather icon-folder" style="font-size: 70px;"></i>
                                                <div><label><?php echo $folder->folder?></label>(<?php echo count($folder->files ?? []) ?> files)</div>
                                            </a>
                                        </div>
                                    <?php endforeach?>
                                </div>
                            </section>

                            <section class="section">
                                <h4>Files</h4>
                                <div class="row">
                                    <?php foreach($folderFilesAndFolders->files as $fileKey => $file) :?>
                                        <?php
                                            $fileName = $file->name;
                                            $ext = explode('.' , $fileName);
                                            $ext = end($ext);
                                        ?>
                                        <?php if( !isEqual( $ext , ['png','gif','jpeg' , 'jpg']) ) :?>
                                            <div class="col-md-4 hover-show-delete mb-3">
                                                <a href="<?php echo _download_wrap($fileName, $file->path)?>">
                                                    <i class="feather icon-file-text" style="font-size: 70px;"></i>
                                                    <div><label><?php echo $file->display_name?></label></div>
                                                </a>

                                                <div class="hidden-delete-button">
                                                    <a href="<?php echo _route('file:delete' , $file->id)?>" style="text-decoration: underline;">Delete</a>
                                                </div>											
                                            </div>
                                        <?php endif?>
                                    <?php endforeach?>
                                </div>
                            </section>
                        <?php endif?>

                        <?php if( isset($filesAndFolders) ) :?>
                            <?php if( ! is_null($filesAndFolders['files']) ) : ?>
                                <div class="row">
                                    <!-- files -->
                                    <?php foreach($filesAndFolders['files'] as $fileKey => $file) :?>
                                        <?php
                                            $fileName = $file->name;
                                            $ext = explode('.' , $fileName);
                                            $ext = end($ext);
                                        ?>
                                        <?php if( isEqual( $ext , ['png','gif','jpeg' , 'jpg']) ) :?>
                                            <div class="col-lg-3 col-md-4 col-xs-6 thumb hover-show-delete">
                                                <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="<?php echo $file->display_name?>"
                                                data-image="<?php echo $file->url.'/'.$fileName?>"
                                                data-target="#image-gallery">
                                                    <img class="img-thumbnail"
                                                        src="<?php echo $file->url.'/'.$fileName?>"
                                                        alt="Another alt text" style="height: 150px;">
                                                </a>

                                                <div class="hidden-delete-button">
                                                    <a href="<?php echo _route('file:delete' , $file->id)?>" style="text-decoration: underline;">Delete</a>
                                                </div>
                                            </div>
                                        <?php endif?>
                                    <?php endforeach?>
                                </div>
                            <?php endif?>

                            <?php if( ! is_null($filesAndFolders['folders']) ) : ?>
                            <div class="row">
                                <!-- files -->
                                <?php foreach($filesAndFolders['folders'] as $folderKey => $folder) :?>
                                    <div class="col-md-4">
                                        <a href="?page=files&folder=<?php echo $folder->id?>">
                                            <i class="feather icon-folder" style="font-size: 70px;"></i>
                                            <div><label><?php echo $folder->folder?></label>(<?php echo count($folder->files ?? []) ?> files)</div>
                                        </a>
                                    </div>
                                <?php endforeach?>
                            </div>
                            <?php endif?>

                        <?php endif?>
                    </section>
                </div>
            </div>
            
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <h4>Government IDs <a href="<?php echo _route('govid:edit', $employment->user_id)?>"><i data-feather="edit"></i></a></h4>
                </div>
                <div class="widget-content widget-content-area">
                    <table class="table table-bordered">
                        <?php foreach($governmentIDs as $key => $row) :?>
                            <tr>
                                <td><?php echo $row->organization?></td>
                                <td><?php echo $row->id_number?></td>
                                <td><?php echo $row->is_verified ? '<span class="badge badge-primary">Verified</span>': '<span class="badge badge-warning">Unverified</span>'?></td>
                            </tr>
                        <?php endforeach?>
                    </table>
                </div>
            </div>

            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <h4>Underlings</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <?php foreach($underlings as $key => $row) :?>
                        <p><?php echo $row->first_name . ' ' .$row->last_name . "($row->manager_name)"?></p>
                    <?php endforeach?>
                </div>
            </div>

        </div>
    </div>
<?php endbuild()?>

<?php build('headers')?>
    <link href="<?php echo _path_tmp('assets/css/users/user-profile.css')?>" rel="stylesheet" type="text/css" />
<?php endbuild()?>


<?php build('styles')?>
    <style type="text/css">
        .hover-show-delete:hover .hidden-delete-button
        {
            display: block;
        }
        
        .hidden-delete-button
        {
            display: none;
        }
    </style>
<?php endbuild()?>


<?php loadTo()?>