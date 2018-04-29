<?php namespace Minhbang\Setting;

class AppZone extends Zone
{
    /**
     * @return string
     */
    protected function defineTitle()
    {
        return __('General');
    }

    /**
     * @return array
     */
    protected function defineSections()
    {
        return [
            'website' => [
                'title'       => __('Website'),
                'description' => __('Website settings'),
                'fields'      => [
                    'name_app'       => [
                        'title'   => __('App name'),
                        'rule'    => 'required|max:40',
                        'default' => 'Laravel Portal',
                    ],
                    'name_short'     => [
                        'title'   => __('Site short name'),
                        'rule'    => 'required|max:40',
                        'default' => 'Laravel App',
                    ],
                    'name_long'      => [
                        'title'   => __('Sitename'),
                        'rule'    => 'required|max:128',
                        'default' => 'Laravel Application Boilerplate',
                    ],
                    'email'          => [
                        'title'   => __('E-mail'),
                        'rule'    => 'required|email',
                        'default' => 'info@domain.com',
                    ],
                    'address'        => [
                        'title'   => __('Address'),
                        'rule'    => 'required|max:255',
                        'default' => 'HCM, VN',
                    ],
                    'tel'            => [
                        'title'   => __('Phone number'),
                        'rule'    => 'required|max:100',
                        'default' => '0123.4567890',
                    ],
                    'header'         => [
                        'title'   => __('Header content'),
                        'rule'    => 'required',
                        'default' => '',
                        'options' => [
                            'type' => 'textarea',
                        ],
                    ],
                    'product_footer' => [
                        'title'   => __('More information when viewing products'),
                        'rule'    => 'required',
                        'default' => '',
                        'options' => [
                            'type' => 'textarea',
                        ],
                    ],
                ],
            ],
            'display' => [
                'title'       => __('Display'),
                'description' => __('Display settings'),
                'fields'       => [
                    'image_width_max'     => [
                        'title'   => __('Max image width'),
                        'rule'    => 'required|integer',
                        'default' => 1024,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_width_md'      => [
                        'title'   => __('Medium image width'),
                        'rule'    => 'required|integer',
                        'default' => 490,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_height_md'     => [
                        'title'   => __('Medium image height'),
                        'rule'    => 'required|integer',
                        'default' => 294,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_width_sm'      => [
                        'title'   => __('Small image width'),
                        'rule'    => 'required|integer',
                        'default' => 110,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_height_sm'     => [
                        'title'   => __('Small image height'),
                        'rule'    => 'required|integer',
                        'default' => 80,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'summary_limit'       => [
                        'title'   => __('Content summary limit'),
                        'rule'    => 'required|integer',
                        'default' => 120,
                    ],
                    'category_page_limit' => [
                        'title'   => __('Item per Category page'),
                        'rule'    => 'required|integer',
                        'default' => 10,
                    ],
                ],
            ],
            'system'  => [
                'title'       => __('System'),
                'description' => __('System settings'),
                'fields'       => [
                    'minify_html'    => [
                        'title'   => __('Minify HTML output'),
                        'rule'    => 'integer',
                        'default' => true,
                        'init'    => false,
                        'filter'  => function ($value) {
                            return $value == 1;
                        },
                        'options' => [
                            'type' => 'checkbox',
                        ],
                    ],
                    'public_files'   => [
                        'title'   => __('Upload directory'),
                        'hint'    => __('Relatively from public_path'),
                        'rule'    => 'required',
                        'default' => 'upload',
                        'filter'  => function ($value) {
                            return trim($value, '/');
                        },
                    ],
                    'max_image_size' => [
                        'title'   => __('Max image file size'),
                        'rule'    => 'required|integer|min:1',
                        'default' => 6,
                        'options' => [
                            'addon' => 'Mb',
                        ],
                    ],
                    'ga_tracking_id' => [
                        'title'   => __('Google Analytics Tracking ID'),
                        'rule'    => 'max:100',
                        'default' => '',
                    ],
                    'fb_app_id'      => [
                        'title'   => __('Facebook Application ID'),
                        'rule'    => 'max:100',
                        'default' => '',
                    ],
                    'fb_api_ver'     => [
                        'title'   => __('Facebook API version'),
                        'rule'    => 'max:100',
                        'default' => '',
                    ],
                ],
            ],
            'contact' => [
                'title'         => __('Contact'),
                'description'   => __('Contact module settings'),
                'is_special'    => true,
                'special_title' => __('Contact module'),
                'fields'        => [
                    'enable'  => [
                        'title'   => __('Status'),
                        'rule'    => 'integer',
                        'default' => false,
                        'init'    => false,
                        'options' => [
                            'type' => 'checkbox',
                        ],
                    ],
                    'name'    => [
                        'title'   => __('Module title'),
                        'rule'    => 'required|max:100',
                        'default' => '',
                    ],
                    'email'   => [
                        'title'   => __('E-mail reception'),
                        'rule'    => 'required|email',
                        'default' => '',
                    ],
                    'form'    => [
                        'title'   => __('Contact form'),
                        'rule'    => 'required',
                        'default' => '',
                        'options' => [
                            'type' => 'form',
                        ],
                    ],
                    'success' => [
                        'title'   => __('Success message'),
                        'hint'    => __('Show when contact information is successfully sent'),
                        'rule'    => 'required|max:255',
                        'default' => '',
                        'options' => [
                            'type' => 'textarea',
                        ],
                    ],
                ],
            ],
        ];
    }
}