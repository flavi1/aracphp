<?php
namespace aracphp;
use aracphp\ressourceClassLoader;

abstract class aRessourceClassFactory {

	abstract static public function tryToDeclare($NS_Prefix, $className, $path);
	
	static public function NS_Suffix() {
		return ucfirst(substr(static::class, 0, - strlen('Factory')));
	}
	
	static public function implement() {
		ressourceClassLoader::implement(static::class);
	}
	
	static public function isOverridableByTheme() {
		return false;
	}
}
