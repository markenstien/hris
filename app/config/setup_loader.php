<?php
    define('SYSTEM_MODE' , $system['mode']);

    switch(SYSTEM_MODE)
    {
        case 'local':
            define('URL' , 'http://dev.hris');
            define('DBVENDOR' , 'mysql');
            define('DBHOST' , 'localhost');
            define('DBUSER' , 'root');
            define('DBPASS' , '');
            define('DBNAME' , 'th_hris');

            define('BASECONTROLLER' , 'AuthController');
            define('BASEMETHOD' , 'index');

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;

        case 'dev':
            define('URL' , '');
            define('DBVENDOR' , '');
            define('DBHOST' , '');
            define('DBUSER' , '');
            define('DBPASS' , '');
            define('DBNAME' , '');

            define('BASECONTROLLER' , 'Pages');
            define('BASEMETHOD' , 'index');

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;

        case 'down':
            define('URL' , '');
            define('DBVENDOR' , '');
            define('DBHOST' , '');
            define('DBUSER' , '');
            define('DBPASS' , '');
            define('DBNAME' , '');

            define('BASECONTROLLER' , 'Maintenance');
            define('BASEMETHOD' , 'index');

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;

        case 'up':
            define('URL' , 'https://www.ntchris.online ');
            define('DBVENDOR' , 'mysql');
            define('DBHOST' , 'localhost');
            define('DBUSER' , 'korpzpru_th_main');
            define('DBPASS' , 'Y[@h=Ytz;(f}');
            define('DBNAME' , 'korpzpru_hris');

            define('BASECONTROLLER' , 'UserController');
            define('BASEMETHOD' , 'index');
        break;
    }
