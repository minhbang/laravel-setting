<?php
return [
    'route_prefix' => 'backend',
    'middleware'   => ['web', 'role:sys.admin'],
    /*
    |--------------------------------------------------------------------------
    | Thư mục lưu các file setting *.json
    |--------------------------------------------------------------------------
    |
    | - Sẽ tạo mới nếu không tồn tại
    | - Các file setting có sẽ được lưu <path>/<namespace>.json
    |
    */
    'path'         => storage_path('settings'),

    // Định nghĩa menus cho setting
    'menus'        => [
        'backend.sidebar.setting.app' => [
            'priority' => 3,
            'url'      => 'route:backend.setting.index|zone:app',
            'label'    => 'trans:setting::app.title',
            'icon'     => 'fa-cog',
            'active'   => ['!backend/setting/app/contact*', 'backend/setting/app*'],
        ],
        /*'backend.sidebar.setting.contact' => [
            'priority' => 3,
            'url'      => 'route:backend.setting.show|zone:app,section:contact',
            'label'    => 'trans:setting::app.sections.contact.title',
            'icon'     => 'fa-cog',
            'active'   => 'backend/setting/app/contact*',
        ],*/
    ],
    // Setting zones
    'zones'        => [
        'app' => \Minhbang\Setting\AppZone::class,
    ],

    'html'         => \Minhbang\Setting\Html::class,

    'default_field_options' => [
        'type'       => 'text',
        'label_size' => 'col-md-4',
        'input_size' => 'col-md-8',
    ],
];
