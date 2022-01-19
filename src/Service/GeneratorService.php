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
        $two_last_measurement = $this->repo->getLastMeasurement($generator->getGeneratorId(), 2);

        $last_measurement = $two_last_measurement[0]->getTime();
        $previous_measurement =  $two_last_measurement[1]->getTime();

        $measurement_time = $last_measurement->diff($previous_measurement);
        
        return[
            'generator_id' => $generator->getGeneratorId(),
            'power' => $two_last_measurement[0]->getPower(),
            'measurement_time' => $measurement_time->f,
        ];
    }
}