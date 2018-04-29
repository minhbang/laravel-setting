<?php namespace Minhbang\Setting;

use Html as HtmlBuilder;
use Form;
use Request;
use Illuminate\Support\ViewErrorBag;

/**
 * Class Presenter
 *
 * @package Minhbang\Setting
 */
class Html
{
    /**
     * @var \Minhbang\Setting\Section
     */
    protected $section;
    /**
     * @var array
     */
    protected $fields;
    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Presenter constructor.
     *
     * @param \Minhbang\Setting\Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
        $this->fields = $section->fields();
        $this->errors = Request::session()->get('errors') ?: new ViewErrorBag();
    }

    /**
     * @return string
     */
    public function showFields()
    {
        $titles = $this->section->titles;
        $values = $this->section->values();
        $types = $this->section->types();
        $html = '';
        foreach ($titles as $name => $title) {
            $value = $values[$name];
            if ($types[$name] == 'form') {
                $value = '<div class="form-horizontal">
                    <div class="form-editor">
                        <div id="form-editor-preview" class="form-editor-preview form-control"></div>
                    </div>
                </div>';
            } elseif ($types[$name] == 'checkbox') {
                $value = HtmlBuilder::yesNoLabel($values[$name]);
            }
            $html .= "<tr><td>{$title}</td><td>{$value}</td></tr>";
        }

        return $html;
    }

    /**
     * @return string
     */
    public function editFields()
    {
        $html = '';
        foreach (array_keys($this->fields) as $name) {
            $html .= $this->field($name);
        }

        return $html;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function field($name)
    {
        $options = $this->fields[$name]['options'];
        $type = mb_array_extract('type', $options);

        return in_array($type, ['text', 'textarea', 'checkbox', 'form']) ?
            call_user_func_array([$this, "{$type}Field"], [$name, $options]) : null;
    }

    /**
     * @param string $name
     * @param array $options
     *
     * @return string
     */
    public function textField($name, $options = [])
    {
        $options = $options + ['class' => 'form-control'];
        $label_size = mb_array_extract('label_size', $options);
        $input_size = mb_array_extract('input_size', $options);
        $addon = mb_array_extract('addon', $options);
        $element = Form::text($name, null, $options);
        if ($addon) {
            $element = "<div class=\"input-group\">$element<span class=\"input-group-addon\">$addon</span></div>";
        }

        return $this->fieldGroup($name, $element, $label_size, $input_size);
    }

    /**
     * @param string $name
     * @param array $options
     *
     * @return string
     */
    public function textareaField($name, $options = [])
    {
        $options = $options + [
                'class'       => 'form-control wysiwyg',
                'data-editor' => 'simple',
                'data-height' => 250,
            ];
        $label_size = mb_array_extract('label_size', $options);
        $input_size = mb_array_extract('input_size', $options);

        return $this->fieldGroup($name, Form::textarea($name, null, $options), $label_size, $input_size);
    }

    /**
     * @param string $name
     * @param array $options
     *
     * @return string
     */
    public function checkboxField($name, $options = [])
    {
        $options = $options + [
                'class'         => 'switch',
                'data-on-text'  => __('Yes'),
                'data-off-text' => __('No'),
            ];
        $label_size = mb_array_extract('label_size', $options);
        $input_size = mb_array_extract('input_size', $options);
        $br = $label_size ? '' : '<br>';

        return $this->fieldGroup($name, $br . Form::checkbox($name, 1, null, $options), $label_size, $input_size);
    }

    /**
     * @param $name
     * @param array $options
     *
     * @return string
     */
    public function formField($name, $options = [])
    {
        $label_size = mb_array_extract('label_size', $options);
        $input_size = mb_array_extract('input_size', $options);
        $id = mb_array_extract('id', $options, "input-{$name}");
        $element = Form::hidden("form", null, ['id' => $id]) . <<<"HTML"
<div class="form-editor" data-input="#{$id}">
    <div id="form-editor-preview" class="form-editor-preview form-control"></div>
    <div class="actions">
        <a href="#" class="btn btn-xs btn-primary" data-type="text"><i class="fa fa-plus"></i> Text Field</a>
        <a href="#" class="btn btn-xs btn-success" data-type="textarea"><i class="fa fa-plus"></i> Textarea Field</a>
        <a href="#" class="btn btn-xs btn-warning" data-type="checkbox"><i class="fa fa-plus"></i> Checkbox</a>
    </div>
</div>
HTML;

        return $this->fieldGroup($name, $element, $label_size, $input_size);
    }

    /**
     * @param string $name
     * @param string $element
     * @param string $label_size
     * @param string $input_size
     *
     * @return string
     */
    public function fieldGroup($name, $element, $label_size = null, $input_size = null)
    {
        $help = $this->errors->has($name) ?
            $this->errors->first($name) :
            (isset($this->fields[$name]['hint']) ? $this->fields[$name]['hint'] : null);

        return '<div class="form-group' . ($this->errors->has($name) ? ' has-error' : '') . '">' .
        Form::label($name, $this->fields[$name]['title'], ['class' => "$label_size control-label"]) .
        ($input_size ? "<div class=\"$input_size\">" : '') .
        $element .
        ($help ? "<p class=\"help-block\">{$help}</p>" : '') .
        ($input_size ? '</div>' : '') .
        '</div>';
    }

    /**
     * @param string $cancel_url
     *
     * @param string $offset_size
     *
     * @param string $buttons_size
     *
     * @return string
     */
    public function buttons($cancel_url = '#', $offset_size = null, $buttons_size = null)
    {
        $offset_size = $offset_size ?: config('setting.default_field_options.label_size');
        $buttons_size = $buttons_size ?: config('setting.default_field_options.input_size');
        $buttons = '<button type="submit" class="btn btn-success" style="margin-right: 15px;">' . __('Save') . '</button>
                <a href="' . $cancel_url . '">' . __('Cancel') . '</a>';

        return '<div class="form-group"><div class="' . $offset_size . '"></div><div class="' . $buttons_size . '">' . $buttons . '</div></div>';
    }
}