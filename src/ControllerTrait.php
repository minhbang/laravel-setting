<?php

namespace Minhbang\Setting;

use App;
use Session;
use Illuminate\Http\Request;

/**
 * Class SettingControllerTrait
 *
 * @package App\Traits
 * @method void buildHeading($title, $icon, $breadcrumbs)
 * @method void validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
 */
trait ControllerTrait
{
    protected $name;
    protected $list_route;
    protected $show_route;
    protected $edit_route;
    /**
     * Danh sách section nằm trong mục Thiết lập,
     * - Bình thường bao gồm tất cả section
     * - Khi muốn tách các section ra mục menu riêng => bỏ nó ra khỏi $lists
     *
     * @var array
     */
    protected $lists;
    /**
     * Các thiết lập mặc định
     *
     * @var array
     */
    protected $value_default;
    /**
     * Giá trị khởi tạo, nếu form submit không có thì "thiết lập" sẽ mang giá trị này
     * VD: thiết lập dạng bool của bootstrap-switch
     *
     * @var array
     */
    protected $value_init;
    /**
     * Định nghĩa các rules cho các section
     *
     * @var array
     */
    protected $rules;

    /**
     * Định nghĩa các custom message cho các rules
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Khởi tạo các biến
     */
    protected function init()
    {
        $this->lists = config("setting.{$this->name}.lists");
        $this->rules = config("setting.{$this->name}.rules");
        $this->value_default = $this->loadDefaults();
        $this->value_init = config("setting.{$this->name}.init");
    }

    /**
     * Kiểm tra section có được định nghĩa chưa
     *
     * @param string $section
     */
    protected function checkSection($section)
    {
        if (!isset($this->value_default[$section])) {
            abort(404, trans('setting::common.section_not_found'));
        }
    }

    /**
     * Danh sách các seting group
     */
    public function getList()
    {
        $sections = $this->lists;
        $this->buildHeading(
            trans('setting::common.title'),
            'wrench',
            trans('setting::common.setting')
        );
        return view("setting::list", compact('sections'));
    }

    /**
     * @param string $section
     * @return \Illuminate\View\View
     */
    public function getShow($section)
    {
        $this->checkSection($section);
        $settings = mb_array_merge($this->value_default[$section], setting("{$this->name}::$section"));
        $section_title = trans("setting::{$section}.{$section}");
        $this->buildHeading(
            trans('setting::common.section', ['section' => $section_title]),
            'wrench',
            [
                route($this->list_route) => trans('setting::common.setting'),
                '#'                      => $section_title
            ]
        );
        $edit_url = route($this->edit_route, ['section' => $section]);
        $locales = config('locale.supported');
        return view(
            "setting::{$section}_show",
            compact('section', 'settings', 'edit_url', 'locales')
        );

    }

    /**
     * @param string $section
     * @return \Illuminate\View\View
     */
    public function getEdit($section)
    {
        $this->checkSection($section);
        $settings = mb_array_merge($this->value_default[$section], setting("{$this->name}::$section", []));
        $section_title = trans("setting::{$section}.{$section}");
        $this->buildHeading(
            trans('setting::common.section', ['section' => $section_title]),
            'wrench',
            [
                route($this->list_route) => trans('setting::common.setting'),
                '#'                      => $section_title
            ]
        );
        return view("setting::{$section}", compact('section', 'settings'));
    }

    /**
     * Lưu thiết lập của $section
     *
     * @param \Illuminate\Http\Request $request
     * @param string $section
     * @return mixed
     */
    public function postEdit(Request $request, $section)
    {
        $this->checkSection($section);
        $rules = $this->getRules($section);
        $messages = array_get($this->messages, $section, []);
        $this->validate($request, $rules, $messages);

        $inputs = $request->all();
        $settings = array_get($this->value_init, $section, []);
        foreach ($inputs as $key => $value) {
            if (!starts_with($key, '_')) {
                $filter = $this->getFilterInput($section, $key);
                $settings[$key] = $filter ? $this->{$filter}($value, $request) : $value;
            }
        }
        setting(["{$this->name}::$section" => $settings]);
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('common.save_object_success', ['name' => trans('setting::common.setting')]),
            ]
        );

        if ($return = $request->get('_return')) {
            return redirect($return);
        } else {
            if (in_array($section, $this->lists)) {
                return redirect(route($this->list_route));
            } else {
                return redirect(route($this->show_route, ['section' => $section]));
            }
        }
    }

    /**
     * Tiến hành phục hồi setting về mặc định
     *
     * @return \Illuminate\View\View
     */
    public function postDefault()
    {
        setting(["{$this->name}::" => $this->value_default]);
        return response()->json(
            [
                'type'    => 'success',
                'content' => trans('setting::common.restore_default_success'),
            ]
        );
    }

    /**
     * @return array
     */
    protected function loadDefaults()
    {
        $origin_defaults = config("setting.{$this->name}.defaults");
        // có đa ngôn ngữ
        if ($locales = config('locale.supported')) {
            $empty_section = array_combine($locales, array_fill(0, count($locales), []));

            $defaults = [];
            foreach ($origin_defaults as $section => $settings) {
                $defaults[$section] = $empty_section;
                $translatable_keys = $this->listTranslatableKeys($section);
                foreach ($settings as $key => $value) {
                    if (in_array($key, $translatable_keys)) {
                        foreach ($locales as $locale) {
                            $defaults[$section][$locale][$key] = $value;
                        }
                    } else {
                        $defaults[$section][$key] = $value;
                    }
                }
            }
            return $defaults;
        } else {
            // không đa ngôn ngữ
            return $origin_defaults;
        }
    }

    /**
     * @param string $section
     * @return array
     */
    protected function listTranslatableKeys($section)
    {
        $rules = array_get(config("setting.{$this->name}.rules"), $section, []);
        $keys = [];
        foreach ($rules as $key => $rule) {
            if ($translatable_key = $this->getTranslatableKey($key)) {
                $keys[] = $translatable_key;
            }
        }
        return $keys;
    }

    /**
     * @param string $section
     * @return array
     */
    protected function getRules($section)
    {
        $origin_rules = array_get($this->rules, $section, []);
        // có đa ngôn ngữ
        if ($locale_required = config('locale.required')) {
            $locales = array_diff(config('locale.supported'), [$locale_required]);

            $rules = [];
            $translatable_keys = [];
            foreach ($origin_rules as $key => $rule) {
                if ($translatable_key = $this->getTranslatableKey($key)) {
                    // attribute đa ngôn ngữ, rule cho ngôn ngữ chính
                    $rules["{$locale_required}.{$translatable_key}"] = $rule;
                    // bỏ rule 'required'
                    $translatable_keys[$translatable_key] = trim(str_replace('required', '', $rule), '|');
                } else {
                    // attribute bình thường
                    $rules[$key] = $rule;
                }
            }
            // set rules cho các attributes đa ngôn ngữ với các ngôn ngữ còn lại => đã bỏ 'required'
            foreach ($locales as $locale) {
                foreach ($translatable_keys as $key => $rule) {
                    $rules["{$locale}.{$key}"] = $rule;
                }
            }
            return $rules;
        } else {
            // không đa ngôn ngữ
            return $origin_rules;
        }
    }

    /**
     * Attribute đa ngôn ngữ bắt đầu bằng dấu _
     *
     * @param string $key
     * @return string|bool
     */
    protected function getTranslatableKey($key)
    {
        return strpos($key, '_') === 0 ? substr($key, 1) : false;
    }

    /**
     * Determine if a filter exists for an input.
     *
     * @param  string $section
     * @param  string $key
     * @return bool|string
     */
    protected function getFilterInput($section, $key)
    {
        $method = 'filter' . studly_case($section) . studly_case($key) . 'Input';

        return method_exists($this, $method) ? $method : false;
    }
}