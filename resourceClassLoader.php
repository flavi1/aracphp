<?php
namespace aracphp;
use aracphp\aResourceClassFactory;



class resourceClassLoader {
	
	static $singletons = [];	// NS_suffix to classFactory instance
	
	static $config = [
		'VENDOR_PATH' => 'vendor',
		'THEME_PATH' => 'theme/default',
	];
	
	static protected $namespacesPaths = [];
	
	public static function addPath($namespace, $setPath) {
		self::$namespacesPaths[self::prefixWith($namespace, '\\')] = self::suffixWith(self::prefixWith($setPath, '/'), '/');
		krsort(self::$namespacesPaths, SORT_STRING);
	}
	
	public static function implement(string $factory) {
		self::$singletons[$factory::NS_Suffix()] = $factory;
	}
	
	public static function loadClass($className) {
echo 'TRY to declare '.$className;
		foreach(self::$singletons as $suffix => $factory) {
			$test = substr($className, - strlen($suffix));
echo "\n".$test.' == '.$suffix.' ? '.var_export($test == $suffix, true).' !';
			if($test == $suffix)
				return self::buildResource($factory, $className);
		}
	}
	
	private function suffixWith($str, $with) {
		if(substr($str, - strlen($with)) !== $with)
			return $str.$with;
		return $str;
	}
	
	private function prefixWith($str, $with) {
		if(strpos($str, $with) !== 0)
			return $with.$str;
		return $str;
	}
	
	private function extractNS($str) {
		$str = dirname(str_replace('\\', '/',$str));
		$str = str_replace('/', '\\',$str);
		return self::prefixWith($str, '\\');
	}
	
	public static function buildResource($factory, $className) {
		$themePath = self::$config['THEME_PATH'];
		$vendorPath = self::$config['VENDOR_PATH'];
		$className = self::prefixWith($className, '\\');
		foreach(self::$namespacesPaths as $ns => $in_path)
			if(strpos($className, $ns) === 0) {
				$ns = $ns.'\\';
				$subClassName = substr($className, strlen($ns));
				if($factory::isOverridableByTheme())
					if($try = $factory::tryToDeclare($ns, $subClassName, $themePath.$in_path))
						return $try;
				if($try = $factory::tryToDeclare($ns, $subClassName, $vendorPath.$in_path))
					return $try;
			}
	}
	
	public static function register($prepend = false) {
echo 'REGITRED!';
		spl_autoload_register('\\aracphp\\resourceClassLoader::loadClass', false, $prepend);
	}
	
}
