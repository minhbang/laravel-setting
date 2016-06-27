<?php namespace Minhbang\Setting;

use Form;
use Request;
use Illuminate\Support\ViewErrorBag;

/**
 * Class Html
 *
 * @package Minhbang\Setting
 */
class Html
{
    /**
     * @var array
     */
    protected $fields;
    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Html constructor.
     *
     * @param \Minhbang\Setting\Section $section
     */
    public function __construct(Section $section)
    {
        $this->fields = $section->fields();
        $this->errors = Request::session()->get('errors') ?: new ViewErrorBag();
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

        return $this->field($name, $element, $label_size, $input_size);
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

        return $this->field($name, Form::textarea($name, null, $options), $label_size, $input_size);
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
                'data-on-text'  => trans('common.yes'),
                'data-off-text' => trans('common.no'),
            ];
        $label_size = mb_array_extract('label_size', $options);
        $input_size = mb_array_extract('input_size', $options);
        $br = $label_size ? '' : '<br>';

        return $this->field($name, $br . Form::checkbox($name, 1, null, $options), $label_size, $input_size);
    }

    /**
     * @param string $name
     * @param string $element
     * @param string $label_size
     * @param string $input_size
     *
     * @return string
     */
    public function field($name, $element, $label_size = null, $input_size = null)
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
     * @return string
     */
    public function buttons($cancel_url = '#')
    {
        return '<button type="submit" class="btn btn-success" style="margin-right: 15px;">' . trans('common.save') . '</button>
                <a href="' . $cancel_url . '">' . trans('common.cancel') . '</a>';
    }
}