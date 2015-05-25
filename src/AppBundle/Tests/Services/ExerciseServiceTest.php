<?php

namespace AppBundle\Tests\Services;

use AppBundle\Services\ExerciseService;

class ExerciseServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetListByWeeks()
    {
        $exerciseRep = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $exerciseRep->expects($this->exactly(3))
            ->method('findBy')
            ->withConsecutive(
                [['date' => new \DateTime('2 weeks ago')]],
                [['date' => new \DateTime('1 week ago')]],
                [['date' => new \DateTime()]]
            )
            ->will($this->returnValue([]));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($exerciseRep));

        $service = new ExerciseService($entityManager);
        $this->assertEquals([[], [], []], $service->getListByWeeks());
    }
}
