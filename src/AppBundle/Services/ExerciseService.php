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

    public function getListByWeeks()
    {
        $repository = $this->entityManager->getRepository("AppBundle:Exercise");

        return [
            $repository->findBy([
                'date' => new \DateTime('2 weeks ago')
            ]),
            $repository->findBy([
                'date' => new \DateTime('1 week ago')
            ]),
            $repository->findBy([
                'date' => new \DateTime()
            ])
        ];
    }
}