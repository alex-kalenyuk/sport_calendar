<?php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class ExerciseService
{
    const TWO_WEEKS_AGO = '2 weeks ago';
    const WEEK_AGO = '1 week ago';
    const TODAY = 'today';

    private $entityManager;

    // todo: it's better to your entity repository itself, not entity manager
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // todo: docstrings pls
    public function getListByWeeks(User $user)
    {
        $repository = $this->entityManager->getRepository("AppBundle:Exercise");
        $list = [];
        $list[self::TWO_WEEKS_AGO] = $repository->findBy([
            'user' => $user,
            'date' => $this->currentTime(self::TWO_WEEKS_AGO)
        ]);
        $list[self::WEEK_AGO] = $repository->findBy([
            'user' => $user,
            'date' => $this->currentTime(self::WEEK_AGO)
        ]);
        $list[self::TODAY] = $repository->findBy([
            'user' => $user,
            'date' => $this->currentTime(self::TODAY)
        ]);

        return $list;
    }

    protected function currentTime($time)
    {
        return new \DateTime($time);
    }
}
