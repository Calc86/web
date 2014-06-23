<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 23.06.14
 * Time: 16:22
 */

class Helper {


    private function __construct()
    {
    }

    private static function getVarName($className, $varName){
        return $className."_".$varName;
    }

    /**
     * Возвращает переменную сессии, если ее нет, то устанавливает дефолтное значение и возвращает его.
     * @param $className
     * @param $varName
     * @param string $default
     * @return string
     */
    public static function getSesVar($className, $varName, $default = ""){
        $var = $default;
        $name = static::getVarName($className, $varName);
        if(isset(WebYii::app()->session[$name]))
            $var = WebYii::app()->session[$name];
        else
            static::setSesVar($className, $varName, $var);
        return $var;
    }

    public static function setSesVar($className, $varName, $value){
        $name = static::getVarName($className, $varName);

        WebYii::app()->session[$name] = $value;
    }

    public static function getUserID(){
        return WebYii::app()->getUser()->getId();
    }

    public static function useLkTheme(){
        WebYii::app()->setTheme('lk');
    }
}