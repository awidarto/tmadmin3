<?php
return array(
    'user_field'=>'email',
    'password_field'=>'pass',
    'user_collection'=>'users',
    'invalidchars'=>array('%','&','|',' ','"',':',';','\'','\\','?','#','(',')','/'),
    'default_theme'=>'default',
    
    'default_picture_search'=>array(
            ''=>'All',
            'has_picture'=>'Has Picture',
            'no_picture'=>'No Picture'
        ),

    'salutation'=>array(
            'Mr'=>'Mr',
            'Mrs'=>'Mrs',
            'Ms'=>'Ms',
        ),
    'send_options'=>array(
            'immediately'=>'Send Now',
            'atdate'=>'At Specified Date'/*,
            'onceaweek'=>'Once A Week',
            'onceamonth'=>'Once A Month'*/
        ),

    'admin_roles'=>array(
            'root'=>'Super Administrator',
            'admin'=>'Administrator',
            'cashier'=>'Cashier',
            'warehouse'=>'Warehouse'
        ),

    );