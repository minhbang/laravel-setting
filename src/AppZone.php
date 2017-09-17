<?php namespace Minhbang\Setting;

class AppZone extends Zone
{
    /**
     * @return string
     */
    protected function defineTitle()
    {
        return trans('setting::app.title');
    }

    /**
     * @return array
     */
    protected function defineSections()
    {
        return [
            'website' => [
                'title'       => trans('setting::app.sections.website.title'),
                'description' => trans('setting::app.sections.website.description'),
                'fields'      => [
                    'name_app'       => [
                        'title'   => trans('setting::app.sections.website.fields.name_app'),
                        'rule'    => 'required|max:40',
                        'default' => 'Laravel Portal',
                    ],
                    'name_short'     => [
                        'title'   => trans('setting::app.sections.website.fields.name_short'),
                        'rule'    => 'required|max:40',
                        'default' => 'Laravel App',
                    ],
                    'name_long'      => [
                        'title'   => trans('setting::app.sections.website.fields.name_long'),
                        'rule'    => 'required|max:128',
                        'default' => 'Laravel Application Boilerplate',
                    ],
                    'email'          => [
                        'title'   => trans('setting::app.sections.website.fields.email'),
                        'rule'    => 'required|email',
                        'default' => 'info@domain.com',
                    ],
                    'address'        => [
                        'title'   => trans('setting::app.sections.website.fields.address'),
                        'rule'    => 'required|max:255',
                        'default' => 'HCM, VN',
                    ],
                    'tel'            => [
                        'title'   => trans('setting::app.sections.website.fields.tel'),
                        'rule'    => 'required|max:100',
                        'default' => '0123.4567890',
                    ],
                    'header'         => [
                        'title'   => trans('setting::app.sections.website.fields.header'),
                        'rule'    => 'required',
                        'default' => '',
                        'options' => [
                            'type' => 'textarea',
                        ],
                    ],
                    'product_footer' => [
                        'title'   => trans('setting::app.sections.website.fields.product_footer'),
                        'rule'    => 'required',
                        'default' => '',
                        'options' => [
                            'type' => 'textarea',
                        ],
                    ],
                ],
            ],
            'display' => [
                'title'       => trans('setting::app.sections.display.title'),
                'description' => trans('setting::app.sections.display.description'),
                'fields'       => [
                    'image_width_max'     => [
                        'title'   => trans('setting::app.sections.display.fields.image_width_max'),
                        'rule'    => 'required|integer',
                        'default' => 1024,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_width_md'      => [
                        'title'   => trans('setting::app.sections.display.fields.image_width_md'),
                        'rule'    => 'required|integer',
                        'default' => 490,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_height_md'     => [
                        'title'   => trans('setting::app.sections.display.fields.image_height_md'),
                        'rule'    => 'required|integer',
                        'default' => 294,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_width_sm'      => [
                        'title'   => trans('setting::app.sections.display.fields.image_width_sm'),
                        'rule'    => 'required|integer',
                        'default' => 110,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'image_height_sm'     => [
                        'title'   => trans('setting::app.sections.display.fields.image_height_sm'),
                        'rule'    => 'required|integer',
                        'default' => 80,
                        'options' => [
                            'addon' => 'px',
                        ],
                    ],
                    'summary_limit'       => [
                        'title'   => trans('setting::app.sections.display.fields.summary_limit'),
                        'rule'    => 'required|integer',
                        'default' => 120,
                    ],
                    'category_page_limit' => [
                        'title'   => trans('setting::app.sections.display.fields.category_page_limit'),
                        'rule'    => 'required|integer',
                        'default' => 10,
                    ],
                ],
            ],
            'system'  => [
                'title'       => trans('setting::app.sections.system.title'),
                'description' => trans('setting::app.sections.system.description'),
                'fields'       => [
                    'minify_html'    => [
                        'title'   => trans('setting::app.sections.system.fields.minify_html'),
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
                        'title'   => trans('setting::app.sections.system.fields.public_files'),
                        'hint'    => trans('setting::app.sections.system.fields.public_files_hint'),
                        'rule'    => 'required',
                        'default' => 'upload',
                        'filter'  => function ($value) {
                            return trim($value, '/');
                        },
                    ],
                    'max_image_size' => [
                        'title'   => trans('setting::app.sections.system.fields.max_image_size'),
                        'rule'    => 'required|integer|min:1',
                        'default' => 6,
                        'options' => [
                            'addon' => 'Mb',
                        ],
                    ],
                    'ga_tracking_id' => [
                        'title'   => trans('setting::app.sections.system.fields.ga_tracking_id'),
                        'rule'    => 'max:100',
                        'default' => '',
                    ],
                    'fb_app_id'      => [
                        'title'   => trans('setting::app.sections.system.fields.fb_app_id'),
                        'rule'    => 'max:100',
                        'default' => '',
                    ],
                    'fb_api_ver'     => [
                        'title'   => trans('setting::app.sections.system.fields.fb_api_ver'),
                        'rule'    => 'max:100',
                        'default' => '',
                    ],
                ],
            ],
            'contact' => [
                'title'         => trans('setting::app.sections.contact.title'),
                'description'   => trans('setting::app.sections.contact.description'),
                'is_special'    => true,
                'special_title' => trans('setting::app.sections.contact.special_title'),
                'fields'        => [
                    'enable'  => [
                        'title'   => trans('setting::app.sections.contact.fields.enable'),
                        'rule'    => 'integer',
                        'default' => false,
                        'init'    => false,
                        'options' => [
                            'type' => 'checkbox',
                        ],
                    ],
                    'name'    => [
                        'title'   => trans('setting::app.sections.contact.fields.name'),
                        'rule'    => 'required|max:100',
                        'default' => '',
                    ],
                    'email'   => [
                        'title'   => trans('setting::app.sections.contact.fields.email'),
                        'rule'    => 'required|email',
                        'default' => '',
                    ],
                    'form'    => [
                        'title'   => trans('setting::app.sections.contact.fields.form'),
                        'rule'    => 'required',
                        'default' => '',
                        'options' => [
                            'type' => 'form',
                        ],
                    ],
                    'success' => [
                        'title'   => trans('setting::app.sections.contact.fields.success'),
                        'hint'    => trans('setting::app.sections.contact.fields.success_hint'),
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