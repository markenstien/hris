<?php

    #################################################
	##             THIRD-PARTY APPS                ##
    #################################################

    define('DEFAULT_REPLY_TO' , '');

    const MAILER_AUTH = [
        'username' => 'super@vitalcare.sbs',
        'password' => 'c;6*CBlLMFFz',
        'host'     => 'vitalcare.sbs',
        'name'     => 'VitalCare',
        'replyTo'  => 'super@vitalcare.sbs',
        'replyToName' => 'VitalCare'
    ];


    const ITEXMO = [
        'key' => 'ST-MARKG387451_V6YZ8',
        'pwd' => '(7]8bu4]ja'
    ];

    #################################################
	##             EXTENDED APPS                   ##
	#################################################
	const APP_EXTENSIONS = [
		'cxbook' => [
			'base_controller' => 'Accounts',
			'base_method'     => 'index'
        ]
    ];

    define('APP_EXTENSIONS_PATH' , APPROOT.DS.'softwares');

	#################################################
	##             SYSTEM CONFIG                ##
    #################################################


    define('GLOBALS' , APPROOT.DS.'classes/globals');

    define('SITE_NAME' , 'vividoptic.online');

    define('APP_NAME' , 'HRIS-NTC');
    define('COMPANY_NAME' , 'NTC');
    define('COMPANY_NAME_ABBR' , 'NTC');


    define('KEY_WORDS' , 'NTC HRIS');
    define('DESCRIPTION' , 'NTC HRIS');
    define('AUTHOR' , 'thesiscapstonemaker');
?>