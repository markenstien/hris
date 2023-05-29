<?php   
    $module = [];
    /**
     * COMPANY MODULE
     */
    $module['thirdparty'] = [
        'paypal' => [
            'sandbox_account' => 'sb-0knjy3991047@business.example.com',
            'client_id'  => 'AeTxGYye5QLyXZokGiE4hhND5GEeu3dxePRXiqa921Sv0z3fz3dWdOCfjF9ChHOd0ldZLq45zxp8f4B4',
            'secret' => 'ENCFd2oWwgazJZyWO3EIqyv_gcU9_yLiSRTyU1_N9u4uzDA2FBN6I-Djciq-e9eAHzuL6L3jlDOM5_Fd'
        ]
    ];

    $module['common'] = [
        'importance-status' => ['LOW','MID','HIGH','CRITICAL']
    ];

    $module['user'] = [
        'types' => [
            'Staff',
            'Administrator',
            'Sub-Administrator'
        ]
    ];

    $module['timesheet'] = [
    'sheet_categories' => [
            'REGULAR',
            'OT'
        ]
    ];

    $module['ee_leave'] = [
        'categories' => [
            'Vacation leave',
            'Parental leave',
            'Sick leave',
            'Unpaid leave'
        ]
    ];
    
    return $module;