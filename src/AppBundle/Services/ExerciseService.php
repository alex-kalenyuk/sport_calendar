<?php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class ExerciseService
{
    const TWO_WEEKS_AGO = '2 weeks ago';
    const WEEK_AGO = '2 weeks ago';
    const TODAY = 'today';

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getListByWeeks(User $user)
    {
        $repository = $this->entityManager->getRepository("AppBundle:Exercise");
        $list = [];
        $list[self::TWO_WEEKS_AGO] = $repository->findBy([
            'user' => $user,
            'date' => new \DateTime(self::TWO_WEEKS_AGO)
        ]);
        $list[self::WEEK_AGO] = $repository->findBy([
            'user' => $user,
            'date' => new \DateTime(self::WEEK_AGO)
        ]);
        $list[self::TODAY] = $repository->findBy([
            'user' => $user,
            'date' => new \DateTime()
        ]);

        return $list;
    }
}
