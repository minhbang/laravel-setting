<?php
namespace Minhbang\Setting;

class Setting
{
    /**
     * The path to save *.json setting files
     *
     * @var string
     */
    protected $path;
    /**
     * @var array
     */
    protected $zones;
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
     * @param array $zones
     */
    public function __construct($path, $zones = [])
    {
        $this->path = $path;
        if (!is_dir($this->path)) {
            @mkdir($this->path, 0777, true);
        }
        $this->zones = $zones;
    }

    /**
     * @param string $name
     *
     * @return \Minhbang\Setting\Zone|null
     */
    public function zone($name)
    {
        if ($this->registered($name)) {
            if (is_string($this->zones[$name])) {
                $this->zones[$name] = new $this->zones[$name]($name, "{$this->path}/{$name}.json");
            }

            return $this->zones[$name];
        } else {
            return null;
        }
    }

    /**
     * Đăng ký thêm setting $zone
     *
     * @param string $zone
     * @param string $class
     */
    public function register($zone, $class)
    {
        $this->zones[$zone] = $class;
    }

    /**
     * @param string $zone
     *
     * @return bool
     */
    public function registered($zone)
    {
        return isset($this->zones[$zone]);
    }
}