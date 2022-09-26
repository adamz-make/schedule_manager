<?php


namespace App\Tests\application\Domain\Service\ScheduleList;

use App\application\Domain\Service\ScheduleList\GetDaysInMonthService;
use Monolog\Test\TestCase;

class GetDaysInMonthServiceTest extends TestCase
{
    public function testproperDateExecuteIsArray()
    {
        $date = new \DateTimeImmutable();
        $service = new GetDaysInMonthService();
        $result = $service->execute($date);
        $this->assertIsArray($result);
    }

    public function testproperDateExecuteIsexactDay()
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', '2022-05-01');
        $service = new GetDaysInMonthService();
        $result = $service->execute($date);
        $this->assertEquals("01", $result[0]->format('d'));
        $this->assertEquals("31", $result[count($result) - 1]->format('d'));
    }


}