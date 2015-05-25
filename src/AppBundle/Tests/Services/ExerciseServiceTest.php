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
                [['user' => $userEntity, 'date' => $this->currentTime(ExerciseService::TWO_WEEKS_AGO)]],
                [['user' => $userEntity, 'date' => $this->currentTime(ExerciseService::WEEK_AGO)]],
                [['user' => $userEntity, 'date' => $this->currentTime(ExerciseService::TODAY)]]
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

        $service = $this->getMockBuilder('\AppBundle\Services\ExerciseService')
            ->setConstructorArgs([$entityManager])
            ->setMethods(array('currentTime'))
            ->getMock();
        $service->expects($this->exactly(3))
            ->method('currentTime')
            ->will($this->returnValueMap($this->getCurrentTimeArgsMap()));

        $this->assertEquals($expectedResult, $service->getListByWeeks($userEntity));
    }

    protected function getCurrentTimeArgsMap()
    {
        return [
            [ExerciseService::TWO_WEEKS_AGO, $this->currentTime(ExerciseService::TWO_WEEKS_AGO)],
            [ExerciseService::WEEK_AGO, $this->currentTime(ExerciseService::WEEK_AGO)],
            [ExerciseService::TODAY, $this->currentTime(ExerciseService::TODAY)],
        ];
    }

    protected function currentTime($time = null)
    {
        return new \DateTime($time);
    }
}
