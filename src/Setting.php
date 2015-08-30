<?php
namespace Minhbang\LaravelSetting;

class Setting
{
    /**
     * The path to save *.json setting files
     *
     * @var string
     */
    protected $path;
    /**
     * The class working array
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Create the Setting instance
     *
     * @param string $path The path to the file
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param string|null $key
     * @param bool $cache
     * @return mixed
     */
    public function get($key = null, $cache = true)
    {
        list($name, $file, $key) = $this->parserKey($key);

        if (!$cache || empty($this->settings[$name])) {
            $this->settings[$name] = is_file($file) ? json_decode(file_get_contents($file), true) : [];
        }

        // Lấy toàn bộ settings
        if (empty($key)) {
            return $this->settings[$name];
        }

        // Lấy settings của 1 section (key không có dấu .)
        if (strpos($key, '.') === false) {
            return isset($this->settings[$name][$key]) ? $this->settings[$name][$key] : [];
        }

        list($section, $key) = explode('.', $key, 2);

        if (isset($this->settings[$name][$section])) {
            $not_found = app('config')->get('app.key') . time();
            $value = array_get($this->settings[$name][$section], $key, $not_found);
            if ($value !== $not_found) {
                // attribue bình thường
                return $value;
            } else {
                // có thể là attribute đa ngôn ngữ
                if ($locale = app('config')->get('app.locale')) {
                    return array_get($this->settings[$name][$section], "{$locale}.{$key}");
                } else {
                    return null;
                }
            }
        } else {
            return array_get(app('config')->get("setting.{$name}.defaults"), "{$section}.{$key}");
        }
    }

    /**
     * @param string|null $key Nếu key = null => replace all setting by value
     * @param mixed $value
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                $this->setValue($innerKey, $innerValue);
            }
        } else {
            $this->setValue($key, $value);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    protected function setValue($key, $value)
    {
        list($name, $file, $key) = $this->parserKey($key);

        if (empty($key)) {
            // replace settings
            $settings = $value;
        } else {
            if (is_file($file)) {
                $settings = json_decode(file_get_contents($file), true);
                if ($settings) {
                    $current = array_get($settings, $key, []);
                    if ($current && is_array($current)) {
                        $value = mb_array_merge($current, $value);
                    }
                }
            } else {
                $settings = [];
            }
            // update settings
            array_set($settings, $key, $value);
        }
        $this->save($file, $settings);
        $this->settings[$name] = $settings;
    }

    /**
     * @param string $key định dạng [name::]key
     * @return array
     */
    protected function parserKey($key)
    {
        if (strpos($key, '::') !== false) {
            list($name, $key) = explode('::', $key, 2);
        } else {
            $name = 'app';
        }
        return [$name, "{$this->path}/{$name}.json", $key];
    }

    /**
     * @param string $file
     * @param array $settings
     */
    protected function save($file, $settings)
    {
        // check setting path
        if (!is_dir($this->path)) {
            @mkdir($this->path, 0777, true);
        }
        // save settings to file
        $fh = fopen($file, 'w+');
        fwrite($fh, json_encode($settings));
        fclose($fh);
    }
}