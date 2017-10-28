<?php
namespace JumandanConfig;

class Client
{
    /** @var array $pathList The list of path where located configs. */
    private static $pathList = [];

    /**
     * It method registers the path into locations list.
     *
     * @param string $path
     */
    public static function reg(string $path)
    {
        if (!is_dir($path)) {
            throw new Exception\ConfigException('Config directory doesn\'t exists', ['path' => $path]);
        }
        self::$pathList[] = $path;
    }

    /**
     * It method returns locations list.
     *
     * @return array
     */
    public static function getPathList(): array
    {
        return self::$pathList;
    }

    /** @var array $configCache The cache of loaded configs. */
    private static $configCache = [];

    private function __construct()
    {
    }

    /**
     * It method gets and cached config essence.
     *
     * @param string $config The requested config name.
     * @param bool $require
     *
     * @return array
     */
    public static function get(string $config, bool $require = true): array
    {
        if (array_key_exists($config, self::$configCache)) {
            return self::$configCache[$config];
        }

        $data = new self();
        $data->load($config, $require);

        self::$configCache[$config] = (array)$data;

        return (array)$data;
    }

    /**
     * It method load a config essence.
     *
     * @param string $config The requested config name.
     * @param bool $require
     */
    private function load(string $config, bool $require)
    {
        $exists = false;

        foreach (self::$pathList as $path) {
            $fn = sprintf('%s/%s.php', $path, $config);
            if (!is_file($fn)) {
                continue;
            }
            require($fn);
            $exists = true;
        }

        if ($require && !$exists) {
            throw new Exception\ConfigException('Config not found', [$config => $config]);
        }
        return $this;
    }
}
