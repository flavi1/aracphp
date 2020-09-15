<?php
namespace \aracphp;

class paths {
	
	static protected $singleton = null;
	
    static protected $paths = [
        'root' => null,
        'www' => 'www/',
        'vendor' => 'vendor/',
        'theme' => 'themes/default',
    ];
    
    static protected $writeProtect = false
    
    static public function addPathSetter(string $pathLabel, string $default = null) {
		self::$paths[$pathLabel] = $default;
	}
    
    public function __construct() {
		if(!is_null(self::$singlton))
			throw new Exception('Error : Paths already defined.');
		else {
			self::$singleton = $this;
		}
	}
	
	public function build() {
		foreach(self::$paths as $pathLabel => $def)
			if(!$def)
				throw new Exception('Error : '.$pathLabel.' is not set!');
		self::$writeProtect = true;
	}
	
	public function __call($pathLabel, $args) {
		if(!isset(self::$paths[$pathLabel]))
			throw new Exception('Error : '.$pathLabel.' unknown label path.');
		if(!isset($args[0]))
			return self::$paths[$pathLabel];
		elseif(!self::$writeProtect)
			self::$paths[$pathLabel] = $args[0];
		else
			throw new Exception('Error : Paths already builded.');
	}
	
	public static function __callStatic($method, $args) {
		return call_user_func_array(array(self::$singleton, $method), $args);
	}
	
}
