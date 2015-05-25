<?php

namespace AppBundle\Tests\Services;

use AppBundle\Services\ExerciseService;

class ExerciseServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetListByWeeks()
    {
        $userEntity = $this->getMock('\AppBundle\Entity\User');
        $exerciseRep = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $exerciseRep->expects($this->exactly(3))
            ->method('findBy')
            ->withConsecutive(
                [['user' => $userEntity, 'date' => new \DateTime(ExerciseService::TWO_WEEKS_AGO)]],
                [['user' => $userEntity, 'date' => new \DateTime(ExerciseService::WEEK_AGO)]],
                [['user' => $userEntity, 'date' => new \DateTime()]]
            )
            ->will($this->returnValue([]));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($exerciseRep));

        $expectedResult = [
            ExerciseService::TWO_WEEKS_AGO => [],
            ExerciseService::WEEK_AGO => [],
            ExerciseService::TODAY => []
        ];
        $service = new ExerciseService($entityManager);
        $this->assertEquals($expectedResult, $service->getListByWeeks($userEntity));
    }
}
