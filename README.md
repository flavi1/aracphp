# aracphp
All Resources Are Classes

aracphp is :
* an extremly thin php library to organize your code as simple as possible
* a design pattern conforms to namespaces against modules approch (see [module vs namespaces on wikipedia](https://en.wikipedia.org/wiki/Module_pattern#Namespaces))
* an autoloader combined with a little abstract class : aResourceClassFactory

# Example
We have :
* vendor/myname/myproject/subfolder/myView.tpl
* theme/default/myname/myproject/subfolder/myView.tpl
Then, we want theme template to override vendor template.

```
<?php


aracphp\ressourceClassLoader::addPath('\myproject', 'myname/myproject');

class templateFactory extends \aracphp\aResourceClassFactory {
    
    /*
        Optionnal : it will automatically extract Template from 'templateFactory' class name */
        This means : all classes suffixed by 'Template' will by searched or compiled by this class.
    */
    
    static function NS_Suffix() {
        return 'Template';
    }
    
    
    /* Optionnal, but false by default */
    
    static public function isOverridableByTheme() {
        return true;
    }
    
    
    /*
        ex :
        $namespace_prefix = '\myproject\';
        $className = 'subfolder\mytemplate'
        $path = '/var/.../theme/default/myname/myproject/subfolder/myView.tpl';
    */
    
    public function tryToDeclare($namespace_prefix, $className, $path) {
        $fileName = substr($className, 0, - strlen(self::NS_Suffix())).'.tpl'; 
        $fileName = str_replace('\\', '/', $fileName);
        // $fileName = 'subfolder\myView.tpl';
        
        $fullPath = $path.$filePath;
        
        // Then you may want to compile a cache php file
        // for a class called "\myproject\subfolder\myViewTemplate"
        // and require_once the resulted file...
    }
    
}

templateFactory::implement();
$tpl = new \myproject\subfolder\myViewTemplate(); // And life became easy.

```

# You may want it...
To construct a no-module framework like this one : [0orZ framework](https://github.com/flavi1/0orZ-framework)

# todo

An optionnal PSR4 loader that allow static class auto initialization (a "magic" method "__init()")
(see [this comment on php manual](https://www.php.net/manual/fr/language.oop5.autoload.php#86195))

Should not enter in conflict with composer if presents

The interface iStaticInitializable indicates to the autoloader that the classe got an __init method and need to be called at first time.
