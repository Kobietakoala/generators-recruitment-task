<?php

namespace App\DataFixtures;

use App\Entity\GeneratorFactory;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GeneratorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        // for better performance
        $generatorFactory = new GeneratorFactory();
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
        gc_collect_cycles();
        $start_date = new DateTime('2019-01-01 00:00:00.00000');
        // $end_date = new DateTime('2019-01-01 10:59:59.999999');
        $end_date = new DateTime('2019-12-31 23:59:59.599999');

        while( $start_date < $end_date ){
            for($gen_id = 1; $gen_id < 21; $gen_id++){
                $tmp_date = $start_date;
                // random milliseconds time for better random data
                $tmp_date->modify('+ '.  mt_rand(0,500) .' milliseconds');
                
                // random power from 0kW to 1000kW
                $generator = $generatorFactory->create($gen_id, mt_rand(0,1000));

                // override time, because generatorFactory set in default current microtime
                $generator->setTime($tmp_date->getTimestamp().".".$tmp_date->format('v'));
                $manager->persist($generator);
                unset($tmp_date, $generator);
            }
            $start_date->modify('+ 500 milliseconds');

            // save data in 20 rows packages
            $manager->flush();
            $manager->clear();

            // just for seeing how long yet
            echo $start_date->format('Y-m-d H:i:s.v')  . " \n";
        }
        unset($date);
    }
}
