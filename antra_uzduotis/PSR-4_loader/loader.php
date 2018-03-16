<?php

class Autoload_Classes
{
    protected $namespace_prefixes = array();
    protected $json = [];

    public function __construct()
    {
        spl_autoload_register(function($class) {
            $prefix = $class;
           
            while (false !== $pos = strrpos($prefix, '\\')) {
                $prefix = substr($class, 0, $pos + 1);
                $relative_class = substr($class, $pos + 1);
                $mapped_file = $this->loadMappedFile($prefix, $relative_class);
                if ($mapped_file) {
                    return $mapped_file;
                }
                $prefix = rtrim($prefix, '\\');
            }
            return false;
        });
    }

    public function get_base_directories()
    {
        $json = json_decode(file_get_contents(dirname(__DIR__) . "\loader.json"), true);
        $this->namespace_prefixes = $json["psr-4"];
    }

    protected function loadMappedFile($prefix, $relative_class)
    {
        if (isset($this->namespace_prefixes[$prefix]) === false) {
            return false;
        }
        foreach ($this->namespace_prefixes[$prefix] as $base_dir) {
            $file = "/" . $base_dir . "/" . str_replace('\\', '/', $relative_class) . '.php';
            if (file_exists(dirname(__DIR__) . $file)) {
                require dirname(__DIR__) . $file;
                return $file;
            }
        }
        return false;
    }
}