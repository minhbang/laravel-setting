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
     * @param array $fields
     * @param string $trans
     * @param \Minhbang\Setting\Zone $zone
     */
    public function __construct($name, $fields, $trans, $zone)
    {
        $this->name = $name;
        $this->title = trans("{$trans}sections.{$name}.title");
        $this->description = trans("{$trans}sections.{$name}.description");
        $this->is_special = $zone->isSpecial($name);
        $this->special_title = $this->is_special ? trans("{$trans}sections.{$name}.special_title") : $this->title;
        $this->return_url = $this->is_special ?
            route('backend.setting.show', ['zone' => $zone->name, 'section' => $name]) :
            route('backend.setting.index', ['zone' => $zone->name]);
        foreach ($fields as $field => &$config) {
            $config['title'] = trans("{$trans}sections.{$name}.fields.{$field}");
            if (isset($config['hint'])) {
                $config['hint'] = trans("{$trans}sections.{$name}.fields.{$field}_hint");
            }
        }
        $this->fields = new Collection($fields);
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