<?php 
    
    /*
    *HANDLES LOGIN AUTHENTICATION
    */
    function loginControls( $userId = null )
    {
        if( is_null($userId) )
            $userId = whoIs('id');

        $checks = [
            'NDA' => false,
            'U_SETUP' => false
        ];
        // check if NDA READY

        // check if account_setup_ready

        $attachmentModel = model('AttachmentMetaModel');

        $userModel = model('UserModel');

        $nda = $attachmentModel->getUserNDA( $userId );

        $user = $userModel->get( $userId );


        /*check for employer*/

        $isEmployer = $user->type;

        if( $user->type != null && isEqual($user->type , 'employer') )
        {

            //check for nda
            if( $nda ){
                Flash::set("Welcome back");
                return redirect("DashboardController");
            }
        }

        if($nda)
            $checks['NDA'] = true;

        if( ! is_null($user->type) )
            $checks['U_SETUP'] = true;
        
        if( !$checks['NDA']) 
        {
            Flash::set("Agreement");
            return redirect( _route('platform_onbarding:nda') );
        }

        if( !$checks['U_SETUP'] ){
            Flash::set("Account setup.");
            return redirect( _route('platform_onbarding:index') );
        }

        Flash::set("Welcome back ! ");
        return redirect('DashboardController');
                
        return $checks;
    }   
    
    function withinNightDiffRange($in,$out , $start , $end)
    {
        $start = strtotime($in);
        $end   = strtotime($out);
        
        if(time() >= $start && time() <= $end) {
          // ok
        } else {
          // not ok
        }
    }


    function mPriorities()
    {
        return [
            'LOW' , 'MID' , 'HIGH'
        ];
    }


    