<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 5:51
 */

namespace ping;


class downRule extends echoRule {
    public function execute()
    {
        if($this->getResultStatus() == Result::DEAD)
            parent::execute();
    }
} 