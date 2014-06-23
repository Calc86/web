<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:36
 */

namespace ping;


class Ping {
    private $tester;
    private $hosts = array();

    function __construct(array $hosts, $default, $defaultRules)
    {
        foreach($hosts as $host => $tests){
            $h = new Host($host);
            array_unshift($tests, $default);
            foreach($tests as $params){
                list($name, $arrParams, $rules) = $params;

                $class = "ping\\".$name."Test";
                $test = new $class($h, $arrParams);
                /** @var $test Test */

                foreach($defaultRules as $rule){
                    $class = "ping\\".$rule."Rule";
                    $test->addRule(new $class($test));
                }

                foreach($rules as $rule){
                    $class = "ping\\".$rule."Rule";
                    $test->addRule(new $class($test));
                }

                $h->addTest($test);
            }

            $this->hosts[] = $h;
        }

        $this->tester = Tester::getInstance();
    }

    public function getHosts(){
        return $this->hosts;
    }
}