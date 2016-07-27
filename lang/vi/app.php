<?php
return [
    'title'    => 'Hệ thống',
    'sections' => [
        'website' => [
            'title'       => 'Website',
            'description' => 'Các thiết lập về Website',
            'fields'      => [
                'name_app'       => 'Tên App',
                'name_long'      => 'Tên Website',
                'name_short'     => 'Tên Website viết tắc',
                'email'          => 'E-mail',
                'address'        => 'Địa chỉ',
                'tel'            => 'Điện thoại',
                'header'         => 'Thông tin trên Header',
                'product_footer' => 'Thông tin thêm khi xem Sản phẩm',
            ],
        ],
        'display' => [
            'title'       => 'Hiển thị',
            'description' => 'Các thiết lập hiển thị',
            'fields'      => [
                'image_width_max'      => 'Chiều rộng hình ảnh lớn nhất',
                'image_width_max_hint' => 'Hình ảnh khi upload sẽ tự động thu nhỏ nếu vượt quá giới hạn này',
                'image_width_md'       => 'Chiều rộng ảnh trung bình',
                'image_width_md_hint'  => 'Ảnh trung bình thường: hình đại diện tin nổi bật...',
                'image_height_md'      => 'Chiều cao ảnh trung bình',
                'image_width_sm'       => 'Chiều rộng ảnh nhỏ',
                'image_width_sm_hint'  => 'Ảnh nhỏ thường: hình đại diện tin thường, thumbnail...',
                'image_height_sm'      => 'Chiều cao ảnh nhỏ',
                'summary_limit'        => 'Max chiều dài Tóm tắc nội dung',
                'category_page_limit'  => 'Số item trên 1 trang Category',
            ],
        ],
        'system'  => [
            'title'       => 'Chung',
            'description' => 'Các thiết chung',
            'fields'      => [
                'minify_html'       => 'Nén HTML output',
                'public_files'      => 'Thự mục upload',
                'public_files_hint' => 'Thư mục con thuộc public_path',
                'max_image_size'    => 'Kích thước file hình ảnh lớn nhất',
                'ga_tracking_id'    => 'Google Analytics Tracking ID',
                'fb_app_id'         => 'Facebook Application ID',
                'fb_api_ver'        => 'Facebook API version',
            ],
        ],
        'contact' => [
            'title'         => 'Liên hệ',
            'special_title' => 'Module Liên hệ',
            'description'   => 'Thiết lập cho module Liên hệ',
            'fields'        => [
                'enable'       => 'Kích hoạt',
                'name'         => 'Tiêu đề module',
                'email'        => 'E-mail tiếp nhận',
                'form'         => 'Form điền thông tin',
                'success'      => 'Thông điệp',
                'success_hint' => 'Thông báo đã tiếp nhận thông tin Liên hệ thành công',
            ],
        ],
    ],
];