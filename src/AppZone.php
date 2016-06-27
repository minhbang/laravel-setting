<?php namespace Minhbang\Setting;

class AppZone extends Zone
{
    /**
     * View namespace
     *
     * @var string
     */
    protected $views = 'setting::app.';
    /**
     * Translation namespace
     *
     * @var string
     */
    protected $trans = 'setting::app.';
    /**
     * Những sections hiển thị mục menu riêng
     *
     * @var array
     */
    protected $special_sections = ['contact'];

    /**
     * @return array
     */
    protected function defineSections()
    {
        return [
            'website' => [
                'name_app'   => [
                    'rule'    => 'required|max:40',
                    'default' => 'Laravel Portal',
                ],
                'name_short' => [
                    'rule'    => 'required|max:40',
                    'default' => 'Laravel App',
                ],
                'name_long'  => [
                    'rule'    => 'required|max:128',
                    'default' => 'Laravel Application Boilerplate',
                ],
                'email'      => [
                    'rule'    => 'required|email',
                    'default' => 'info@domain.com',
                ],
                'address'    => [
                    'rule'    => 'required|max:255',
                    'default' => 'HCM, VN',
                ],
                'tel'        => [
                    'rule'    => 'required|max:100',
                    'default' => '0123.4567890',
                ],
                'header'     => [
                    'rule'    => 'required',
                    'default' => '',
                ],
            ],
            'display' => [
                'image_width_max'     => [
                    'rule'    => 'required|integer',
                    'default' => 900,
                ],
                'image_width_md'      => [
                    'rule'    => 'required|integer',
                    'default' => 490,
                ],
                'image_height_md'     => [
                    'rule'    => 'required|integer',
                    'default' => 294,
                ],
                'image_width_sm'      => [
                    'rule'    => 'required|integer',
                    'default' => 110,
                ],
                'image_height_sm'     => [
                    'rule'    => 'required|integer',
                    'default' => 80,
                ],
                'summary_limit'       => [
                    'rule'    => 'required|integer',
                    'default' => 120,
                ],
                'category_page_limit' => [
                    'rule'    => 'required|integer',
                    'default' => 10,
                ],
            ],
            'system'  => [
                'minify_html'    => [
                    'rule'    => 'integer',
                    'default' => true,
                    'init'    => false,
                    'filter'  => function ($value) {
                        return $value == 1;
                    },
                ],
                'public_files'   => [
                    'rule'    => 'required',
                    'default' => 'upload',
                    'hint'    => true,
                    'filter'  => function ($value) {
                        return trim($value, '/');
                    },
                ],
                'max_image_size' => [
                    'rule'    => 'required|integer|min:1',
                    'default' => 6,
                ],
                'ga_tracking_id' => [
                    'rule'    => 'max:100',
                    'default' => '',
                ],
                'fb_app_id'      => [
                    'rule'    => 'max:100',
                    'default' => '',
                ],
                'fb_api_ver'     => [
                    'rule'    => 'max:100',
                    'default' => '',
                ],
            ],
            'contact' => [
                'enable'  => [
                    'rule'    => 'integer',
                    'default' => false,
                    'init'    => false,
                ],
                'name'    => [
                    'rule'    => 'required|max:100',
                    'default' => '',
                ],
                'email'   => [
                    'rule'    => 'required|email',
                    'default' => '',
                ],
                'form'    => [
                    'rule'    => 'required',
                    'default' => '',
                ],
                'success' => [
                    'rule'    => 'required|max:255',
                    'default' => '',
                    'hint' => true,
                ],
            ],
        ];
    }
}