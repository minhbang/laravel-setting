<?php namespace Minhbang\Setting;

use Illuminate\Support\Collection;

/**
 * Class Section
 *
 * @property-read string $name
 * @property-read string $title
 * @property-read string $special_title
 * @property-read string $description
 * @property-read bool $is_special
 * @property-read string $return_url
 *
 * @property-read array $titles
 * @property-read array $defaults
 * @property-read array $rules
 *
 * @package Minhbang\Setting
 */
class Section
{
    /**
     * @var bool
     */
    protected $is_special;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $special_title;
    /**
     * @var string
     */
    protected $return_url;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $fields;
    /**
     * @var \Minhbang\Setting\Zone
     */
    protected $zone;

    /**
     * Section constructor.
     *
     * @param string $name
     * @param array $section
     * @param \Minhbang\Setting\Zone $zone
     */
    public function __construct($name, $section, $zone)
    {
        $this->name = $name;
        $this->title = $section['title'];
        $this->description = $section['description'];
        $this->is_special = isset($section['is_special']) && $section['is_special'];
        $this->special_title = isset($section['special_title']) ? $section['special_title'] : $this->title;
        $this->return_url = $this->is_special ?
            route('backend.setting.show', ['zone' => $zone->name, 'section' => $name]) :
            route('backend.setting.index', ['zone' => $zone->name]);

        $default_options = config('setting.default_field_options');
        foreach ($section['fields'] as $field => &$config) {
            $config = mb_array_merge(['options' => $default_options], $config);
        }
        $this->fields = new Collection($section['fields']);

        $this->zone = $zone;
    }

    /**
     * @return array
     */
    public function values()
    {
        return $this->zone->values($this->name);
    }

    /**
     * @param string $attribute
     *
     * @return \Illuminate\Support\Collection
     */
    public function pluck($attribute)
    {
        return $this->fields->keys()->combine($this->fields->pluck($attribute));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function types()
    {
        return $this->fields->keys()->combine($this->fields->pluck('options.type'));
    }

    /**
     * @return array
     */
    public function fields()
    {
        return $this->fields->all();
    }

    /**
     * @param string $field
     *
     * @return bool
     */
    public function has($field)
    {
        return $this->fields->has($field);
    }

    /**
     * Có field dạng form
     */
    public function getFormField()
    {
        $types = $this->types();
        foreach ($types as $field => $type) {
            if ($type == 'form') {
                return $field;
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @param string $type
     *
     * @return bool
     */
    public function fieldIs($name, $type)
    {
        return ($field = $this->fields->get($name)) ? ($field['options']['type'] == $type) : false;
    }

    /**
     * @param array $data
     */
    public function update($data)
    {
        $values = $this->pluck('init')->all();
        $filters = $this->pluck('filter')->all();
        foreach ($data as $field => $value) {
            if ($this->has($field)) {
                $values[$field] = isset($filters[$field]) ? call_user_func($filters[$field], $value) : $value;
            }
        }

        $this->zone->update($this->name, $values);
    }

    /**
     * @param string $name
     *
     * @return string|array|null
     */
    function __get($name)
    {
        if (in_array($name, ['name', 'title', 'special_title', 'description', 'is_special', 'return_url'])) {
            return $this->{$name};
        } elseif (in_array($name, ['titles', 'defaults', 'rules'])) {
            return $this->pluck(substr($name, 0, -1))->all();
        } else {
            return null;
        }
    }
}