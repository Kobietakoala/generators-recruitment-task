<?php

namespace App\Entity;

use App\Repository\GeneratorRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GeneratorRepository::class)]
class Generator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'smallint')]
    private $generator_id;

    #[ORM\Column(type: 'integer')]
    private $power;

    #[ORM\Column(type: 'float')]
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGeneratorId(): ?int
    {
        return $this->generator_id;
    }

    public function setGeneratorId(int $generator_id): self
    {
        $this->generator_id = $generator_id;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getTime(): ?DateTime
    {
        
        $utime = sprintf('%.4f', $this->time);
        $date = DateTime::createFromFormat('U.u', $utime);
        return $date;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function toArray(): Array{
        return [
            'generator_id' => $this->generator_id,
            'power' => $this->power,
            'time' =>  $this->getTime()->format('Y-m-d H:i:s.u')
        ];
    }
}
