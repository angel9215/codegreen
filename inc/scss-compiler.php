<?php
    /**
 * Wrapper class for SCSSPHP
 *
 * @package codeGreen
 */
 //Import scss
 include_once __DIR__ . '/../lib/scss/scss.inc.php';

class ScssCompiler {
    public static $_themePath = null;
    
    private static function _getThemePath() {
        if (self::$_themePath == null) {
            return get_template_directory();
        } else {
            return self::_themePath;
        }
    }
    
    public static function compile($scssString, $optionsCallback = null) {
        
        $scss = new \Leafo\ScssPhp\Compiler();
        $scss->setImportPaths(self::_getThemePath());
        
        if (is_callable($optionsCallback)) {
            $optionsCallback($scss);
        }
        
        return $scss->compile($scssString);
    }
    
    public static function compileFile($scssSource, $cssDestination, $optionsCallback = null) {
        $scss = file_get_contents($scssSource);
        
        self::compileString($scss, $cssDestination, $optionsCallback);
    }
    
    public static function compileString($scssString, $cssDestination, $optionsCallback = null) {
        $css = self::compile($scssString, $optionsCallback);
        
        file_put_contents($cssDestination, $css, LOCK_EX);
    }
 }