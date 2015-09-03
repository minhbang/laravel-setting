<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Thư mục lưu các file setting *.json
    |--------------------------------------------------------------------------
    |
    | - Sẽ tạo mới nếu không tồn tại
    | - Các file setting có sẽ được lưu <path>/<namespace>.json
    |
    */
    'path' => storage_path('settings'),
    /*
    |--------------------------------------------------------------------------
    | Cấu hình 'app' namespace
    |--------------------------------------------------------------------------
    |
    | 'app' là namespace mặc định nếu không chỉ rỏ sử dụng namespace nào
    |
    */
    'app'  => [
        /**
         * Các section xuất hiện trong trang list setting
         */
        'lists'    => ['app', 'display', 'system'],
        /**
         * Dùng validation input, LƯU Ý:
         * - rule required (nếu có) phải đứng ĐẦU hoặc CUỐI
         * - attribute đa ngôn ngữ có tên bắt đầu bằng dấu _ (gạch dưới)
         */
        'rules'    => [
            'app'     => [
                'name_short' => 'required|max:40',
                'name_long'  => 'required|max:128',
                'email'      => 'required|email',
                'address'    => 'required|max:255',
                'tel'        => 'required|max:100',
            ],
            'display' => [
                'image_width_max'     => 'required|integer',
                'image_width_md'      => 'required|integer',
                'image_height_md'     => 'required|integer',
                'image_width_sm'      => 'required|integer',
                'image_height_sm'     => 'required|integer',
                'summary_limit'       => 'required|integer',
                'category_page_limit' => 'required|integer'
            ],
            'system'  => [
                'public_files'   => 'required',
                'max_image_size' => 'required|integer|min:1',
                'ga_tracking_id' => 'max:100',
                'fb_app_id'      => 'max:100',
                'fb_api_ver'     => 'max:100',
            ],
            'contact' => [
                'name'    => 'required|max:100',
                'email'   => 'required|email',
                'form'    => 'required',
                'success' => 'required|max:255',
            ],
        ],
        /**
         * Các giá trị mặc định
         */
        'defaults' => [
            'app'     => [
                'name_short' => 'Laravel App',
                'name_long'  => 'Laravel Application Boilerplate',
                'email'      => 'info@domain.com',
                'address'    => 'HCM, VN',
                'tel'        => '0123.4567890',
            ],
            'display' => [
                'image_width_max'     => 900,
                'image_width_md'      => 490,
                'image_height_md'     => 294,
                'image_width_sm'      => 110,
                'image_height_sm'     => 80,
                'summary_limit'       => 120,
                'category_page_limit' => 10,
            ],
            'system'  => [
                'minify_html'    => true,
                'public_files'   => 'upload',
                'max_image_size' => 6,
                'ga_tracking_id' => '',
                'fb_app_id'      => '',
                'fb_api_ver'     => '',
            ],
            'contact' => [
                'enable'  => false,
                'name'    => '',
                'email'   => '',
                'form'    => '',
                'success' => '',
            ],
        ],
        /**
         * Các giá trị khi khởi tạo form (nếu cần), thường dùng cho bool value
         */
        'init'     => [
            'system'  => [
                'minify_html' => false,
            ],
            'contact' => [
                'enable' => false,
            ],
        ],
    ],
    // các namespace khác khai báo tiếp theo tương tự như 'app'
];
