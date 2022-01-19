<?php

namespace App\Service;

use App\Entity\Generator;
use App\Entity\GeneratorFactory;
use App\Repository\GeneratorRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

class GeneratorService
{   
    private GeneratorFactory $factory;
    private GeneratorRepository $repo;

    public function __construct(private ManagerRegistry $doctrine) {
        $this->factory = new GeneratorFactory();
        $this->repo = $this->doctrine->getRepository(Generator::class);
    }

    public function create(int $generator_id, int $power): Generator{
        $generator = $this->factory->create($generator_id, $power);
        $doctrine = $this->doctrine->getManager();
        $doctrine->persist($generator);
        $doctrine->flush();
        return $generator;
    }

    public function getGeneratorData(Generator $generator) :Array{
        $measurement = $this->repo->getByGeneratorId($generator->getGeneratorId());
        
        return $measurement[0]->toArray();
    }

    public function getMeasurementList($generator_id, \DateTime $start, \DateTime $end, int $page): Array{
        $start->setTime(0,0);
        $end->setTime(23,59,59,599999);
        $first_result = 20 * ($page - 1);
        $max_result = 20 * $page;
        $measurement_list = $this->repo->findMeasurementByGeneratorId(
                $generator_id, 
                $start->getTimestamp(), 
                $end->getTimestamp(), 
                $first_result,
                $max_result
            );

        foreach($measurement_list as &$measurement){
            $measurement = $measurement->toArray();
        }

        return $measurement_list;
    }

}