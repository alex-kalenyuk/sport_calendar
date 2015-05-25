<?php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class ExerciseService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getListByWeeks(User $user)
    {
        $repository = $this->entityManager->getRepository("AppBundle:Exercise");

        return [
            $repository->findBy([
                'user' => $user,
                'date' => new \DateTime('2 weeks ago')
            ]),
            $repository->findBy([
                'user' => $user,
                'date' => new \DateTime('1 week ago')
            ]),
            $repository->findBy([
                'user' => $user,
                'date' => new \DateTime()
            ])
        ];
    }
}