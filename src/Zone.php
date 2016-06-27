<?php namespace Minhbang\Setting;

/**
 * Class Zone
 *
 * @property-read string $name
 * @property-read string $title
 * @property-read string $file
 * @package Minhbang\Setting\Zones
 */
abstract class Zone
{
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
    protected $file;
    /**
     * View namespace
     *
     * @var string
     */
    protected $views;
    /**
     * Translation namespace
     *
     * @var string
     */
    protected $trans;
    /**
     * Những sections hiển thị mục menu riêng
     *
     * @var array
     */
    protected $special_sections = [];
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var \Minhbang\Setting\Section[]
     */
    protected $sections = [];

    /**
     * 1. Validation input, LƯU Ý:
     * - rule required (nếu có) phải đứng ĐẦU hoặc CUỐI
     * - attribute đa ngôn ngữ có tên bắt đầu bằng dấu _ (gạch dưới)
     *
     * @return array
     */
    abstract protected function defineSections();

    /**
     * Zone constructor.
     *
     * @param string $name
     * @param string $file
     */
    public function __construct($name, $file)
    {
        $this->name = $name;
        $this->title = trans("{$this->trans}title");
        $this->file = $file;
        abort_unless($this->trans || $this->views, 500, 'Setting zone: $views && $trans is empty');
        $this->sections = $this->defineSections();
    }

    /**
     * List section obj
     *
     * @return array
     */
    public function sections()
    {
        $sections = array_diff(array_keys($this->sections), $this->special_sections);

        return array_map(function ($section) {
            return $this->section($section);
        }, $sections);
    }

    /**
     * @param string $name
     *
     * @return \Minhbang\Setting\Section
     */
    public function section($name)
    {
        if ($this->has($name)) {
            if (is_array($this->sections[$name])) {
                $this->sections[$name] = new Section($name, $this->sections[$name], $this->trans, $this);
            }

            return $this->sections[$name];
        } else {
            return null;
        }
    }

    /**
     * @param string $section
     *
     * @return bool
     */
    public function has($section)
    {
        return $section && isset($this->sections[$section]);
    }

    /**
     * Lấy các giá trị của cả $section
     *
     * @param $section
     * @param array $default
     *
     * @return array|mixed
     */
    public function values($section, $default = [])
    {
        if (empty($this->values)) {
            $this->values = is_file($this->file) ? json_decode(file_get_contents($this->file), true) : [];
        }
        if (isset($this->values[$section])) {
            return $this->values[$section];
        } else {
            return $this->has($section) ? $this->section($section)->defaults : $default;
        }
    }

    /**
     * Lấy giá trị của một $key
     *
     * @param string $key
     * @param mixed $default
     *
     * @return array|mixed
     */
    public function get($key, $default = null)
    {
        if (empty($key) || strpos($key, '.') === false) {
            return $this->values($key, $default);
        }
        list($section, $key) = explode('.', $key, 2);

        return array_get($this->values($section, []), $key, $default);
    }

    /**
     * @param string $section
     * @param array $values
     */
    public function update($section, $values)
    {
        if ($current = $this->values($section)) {
            $values = mb_array_merge((array)$current, $values);
        }
        $this->values[$section] = $values;
        $this->save();
    }

    /**
     * @param string $section
     *
     * @return bool
     */
    public function isSpecial($section)
    {
        return in_array($section, $this->special_sections);
    }

    /**
     * Phục hồi giá trị mặc định
     */
    public function restore()
    {
        $defaults = [];
        foreach ($this->defineSections() as $section => $fields) {
            if (!$this->isSpecial($section)) {
                $defaults[$section] = [];
                foreach ($fields as $field => $config) {
                    $defaults[$section][$field] = $config['default'];
                }
            }
        }
        $this->values = $defaults + $this->values;
        $this->save();
    }

    /**
     * Save $settings to file
     */
    public function save()
    {
        $fh = fopen($this->file, 'w+');
        fwrite($fh, json_encode($this->values));
        fclose($fh);
    }

    /**
     * @param string $name
     * @param array $data
     * @param array $mergeData
     *
     * @return \Illuminate\View\View
     */
    public function view($name, $data = [], $mergeData = [])
    {
        return view("{$this->views}$name", $data, $mergeData);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    function __get($name)
    {
        return in_array($name, ['file', 'name', 'title']) ? $this->{$name} : null;
    }
}