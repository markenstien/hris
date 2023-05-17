<?php   

    function btnCreate( $route  , $text = 'Create', $attributes  = null)
    {
        $attributes = keypair_to_str($attributes ?? []);
        return <<<EOF
            <a href="{$route}" class="btn btn-primary btn-xs" {$attributes}><i class='fa fa-plus'> </i> {$text} </a>
        EOF;
    }
    
    function btnView( $route  , $text = 'Show', $attributes  = null)
    {
        $attributes = keypair_to_str($attributes ?? []);
        return <<<EOF
            <a href="{$route}" class="btn btn-primary btn-xs" {$attributes}><i class='fa fa-eye'> </i> {$text} </a>
        EOF;
    }

    function btnEdit( $route  , $text = 'Edit', $attributes  = null )
    {
        $attributes = keypair_to_str($attributes ?? []);
        return <<<EOF
            <a href="{$route}" class="btn btn-primary btn-xs" {$attributes}><i class='fa fa-edit'> </i> {$text}  </a>
        EOF;
    }

    function btnDelete( $route  , $text = 'Delete', $attributes  = null )
    {
        $attributes = keypair_to_str($attributes ?? []);
        return <<<EOF
            <a href="{$route}" class="form-verify btn btn-danger btn-xs" {$attributes}><i class='fa fa-trash'> </i> {$text} </a>
        EOF;
    }

    function btnList( $route  , $text = 'List', $attributes  = null )
    {
        $attributes = keypair_to_str($attributes ?? []);
        return <<<EOF
            <a href="{$route}" class="btn btn-primary btn-xs" {$attributes}><i class='fa fa-list'> </i> {$text}  </a>
        EOF;
    }

    /*
    *ancors
    *['url' , 'icon' , 'text']
    */
    function anchorList( $anchors = [])
    {
        $token = random_letter(12);

        $html  = <<<EOF
        <div class="dropdown mb-2">
        <button class="btn p-0" type="button" id="dropdownMenuButton-{$token}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-{$token}">
        EOF;

        foreach($anchors as $anchor)
        {
            $html .= <<<EOF
            <a class="dropdown-item d-flex align-items-center" href="{$anchor['url']}">
                <i data-feather="{$anchor['icon']}" class="icon-sm me-2"></i> 
            <span class="">{$anchor['text']}</span></a>
            EOF;
        }

        $html.= <<<EOF
            </div>
        </div>
        EOF;

        return $html;
    }

    function anchor( $route , $type = 'edit' , $text = null , $color = null)
    {
        $icon = 'edit';
        $a_text = 'Edit';
        $a_color = 'primary';

        switch($type)
        {
            case 'delete':
                $icon = 'trash';
                $a_text = 'Delete';
            break;
            case 'edit':
                $icon = 'edit';
                $a_text = 'Edit';
            break;

            case 'view':
                $icon = 'eye';
                $a_text = 'Show';
            break;

            case 'create':
                $icon = 'plus';
                $a_text = 'Create';
            break;

            default:
                $icon = 'fa-check-circle';
        }

        if( !is_null($text) )
            $a_text = $text;

        if( !is_null($color) )
            $a_color = 'danger';

        return <<<EOF
            <a href="{$route}" class='text-{$a_color}'><i class='fa fa-{$icon}'> </i> {$a_text}  </a>
        EOF;
    }


    //depricated
    function divider()
    {
        echo die("DIVIDER FUNCTION IS DEPRICATED");
        print <<<EOF
            <div style='margin:30px 0px'>
            </div>
        EOF;
    }

    function wReturnLink( $route )
    {
        print <<<EOF
            <a href="{$route}">
                <i class="feather icon-corner-up-left"></i> Return
            </a>
        EOF;
    }

    function wLinkDefault($link , $text = 'Edit' , $attributes = [])
    {   
        $icon = isset($attributes['icon']) ? "<i data-feather='{$attributes['icon']}'> </i>" : null;
        $attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);
        return <<<EOF
            <a href="{$link}" style="text-decoration:underline" {$attributes}>{$icon} {$text}</a>
        EOF;
    }

    function wWrapSpan($text)
    {
        $retVal = '';
        
        if(is_array($text))
        {
            foreach($text as $key => $t) 
            {
                if( $key > 3 )
                    $classHide = '';
                $retVal .= "<span class='badge badge-primary badge-classic'> {$t} </span>";
            }
        }else{
            $retVal = "<span class='badge badge-primary badge-classic'> {$text} </span>";
        }

        return $retVal;
    }

    

    function wDivider($size = '30')
    {
        return <<<EOF
            <div style="margin-top:{$size}px"> </div>
        EOF;
    }

    /*
	*metaId
	*metaKey
	*redirectTo
	*/
	function wFileUploadForm($metaId , $metaKey , $route = null, $redirectTo = null , $folderId = null)
	{	
		$targetAndModalName = random_letter(17 , 'MODAL');


		$folder = model('FolderModel');

		$folders = $folder->getAssoc('folder' , [
			'meta_id' => $metaId,
			'meta_key' => $metaKey
		]);


		$foldersIdAndName = arr_layout_keypair( $folders , ['id' , 'folder'] );

		?>

		<button type="button" 
		class="btn btn-primary mt-1" 
		data-toggle="modal" 
		data-target=".<?php echo $targetAndModalName?>"> <i data-feather="file-plus"></i> </button>

		<div class="modal fade <?php echo $targetAndModalName?>" tabindex="-1" role="dialog" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title" id="exampleLargeModalLabel">Upload Files</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	                    <?php
	                    	Form::open([
	                    		'method' => 'post',
	                    		'action' => _route('file:upload'),
	                    		'enctype' => 'multipart/form-data'
	                    	]);

	                    	Form::hidden('meta_id' , $metaId);
	                    	Form::hidden('meta_key' , $metaKey);
	                    	Form::hidden('redirect_to' , $redirectTo);

	                    	if( !is_null($folderId) )
	                    		Form::hidden('folder_id' , $folderId);
	                    ?>

	                    <div class="form-group">
	                    	<?php
	                    		Form::label('Files');
	                    		Form::file('files[]' , [
	                    			'multiple' => true,
	                    			'class' => 'form-control'
	                    		]);
	                    	?>
	                    </div>

	                    <div class="form-group">
	                    	<?php
	                    		Form::label('Folder');

	                    		Form::text('folder_name' , '' ,[
	                    			'class' => 'form-control'
	                    		]);

	                    		Form::small("Leave folder name if you don't want sub-folder");
	                    	?>
	                    </div>

	                    <div class="form-group">
	                    	<?php
	                    		Form::submit('' , 'Upload File');
	                    	?>
	                    </div>
	                    <?php Form::close()?>
	                </div>
	            </div>
	        </div>
	    </div>
		<?php
	}

	function wFolderAddForm($metaId , $metaKey , $route , $redirectTo = null , $parentId = null)
	{
		$targetAndModalName = random_letter(17 , 'MODAL');
		?>
		<button type="button" 
		class="btn btn-primary mt-1" 
		data-toggle="modal" 
		data-target=".<?php echo $targetAndModalName?>"> <i data-feather="file-plus"></i> </button>

		<div class="modal fade <?php echo $targetAndModalName?>" tabindex="-1" role="dialog" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title" id="exampleLargeModalLabel">Create Folder</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	                    <?php
	                    	Form::open([
	                    		'method' => 'post',
	                    		'action' => $route,
	                    		'enctype' => 'multipart/form-data'
	                    	]);

	                    	Form::hidden('meta_id' , $metaId);
	                    	Form::hidden('meta_key' , $metaKey);

	                    	if( !is_null($redirectTo) ) 
	                    		Form::hidden('redirect_to' , $redirectTo);

	                    	if( !is_null($parentId) )
	                    		Form::hidden('parentId' , $parentId);
	                    ?>
	                    <div class="form-group">
	                    	<?php
	                    		Form::label('Folder');
	                    		Form::text('folder_name' , '' ,[
	                    			'multiple' => true,
	                    			'class' => 'form-control'
	                    		]);
	                    	?>
	                    </div>

	                    <div class="form-group">
	                    	<?php
	                    		Form::submit('' , 'Upload File');
	                    	?>
	                    </div>
	                    <?php Form::close()?>
	                </div>
	            </div>
	        </div>
	    </div>
		<?php
	}