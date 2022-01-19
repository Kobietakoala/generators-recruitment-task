<?php
namespace App\Entity;

use DateTime;

class GeneratorFactory{
    public static function create(int $generator_id, int $power ) :Generator{
        $generator = new Generator();
        $generator->setGeneratorId($generator_id);
        $generator->setPower($power);
        $generator->setTime(microtime(true));
        
        return $generator;
    }

}