<?php
namespace aracphp;
use aracphp\resourceClassLoader;

abstract class aResourceClassFactory {

	abstract static public function tryToDeclare($NS_Prefix, $className, $path);
	
	static public function NS_Suffix() {
		return ucfirst(substr(static::class, 0, - strlen('Factory')));
	}
	
	static public function implement() {
		resourceClassLoader::implement(static::class);
	}
	
	static public function isOverridableByTheme() {
		return false;
	}
}
