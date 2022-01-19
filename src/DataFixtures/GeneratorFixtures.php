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
        $generatorFactory = new GeneratorFactory();
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
        gc_collect_cycles();
        $start_date = new DateTime('2019-01-01 00:00:00.00000');
        // $end_date = new DateTime('2019-01-01 10:59:59.999999');
        $end_date = new DateTime('2019-12-31 23:59:59.599999');

        while( $start_date < $end_date ){
            for($gen_id = 1; $gen_id < 21; $gen_id++){
                $tmp_date = $start_date;
                $tmp_date->modify('+ '.  mt_rand(0,500) .' milliseconds');

                $generator = $generatorFactory->create($gen_id, mt_rand(0,1001));
                $generator->setTime($tmp_date->getTimestamp().".".$tmp_date->format('v'));
                $manager->persist($generator);
                unset($tmp_date, $generator);
            }
            $start_date->modify('+ 500 milliseconds');
            $manager->flush();
            $manager->clear();

            echo $start_date->format('Y-m-d H:i:s.v')  . " \n";
        
        }
        unset($date);
    }
}
