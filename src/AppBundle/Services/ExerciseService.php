<?php
namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;

class ExerciseService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getList()
    {
        return $this->entityManager->getRepository("AppBundle:Exercise")->findAll();
    }
}