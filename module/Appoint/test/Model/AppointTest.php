<?php
namespace AppointTest\Model;

use Appoint\Model\Appoint;
use PHPUnit\Framework\TestCase;

class AppointTest extends TestCase
{
    public function testInitialAppointValuesAreNull()
    {
        $appoint = new Appoint();

        $this->assertNull($appoint->patientName, '"patient" should be null by default');
        $this->assertNull($appoint->id, '"id" should be null by default');
        $this->assertNull($appoint->reason, '"reason" should be null by default');
        $this->assertNull($appoint->startTime, '"startTime" should be null by default');
        $this->assertNull($appoint->endTime, '"endTime" should be null by default');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $appoint = new Appoint();
        $data  = [
            'patientName' => 'some name',
            'id'     => 12,
            'reason'  => 'appointment reason',
            'startTime'  => 'Start time',
            'endTime'  => 'end time'
        ];

        $appoint->exchangeArray($data);

        $this->assertSame(
            $data['patientName'],
            $appoint->patientName,
            '"patientName" was not set correctly'
        );

        $this->assertSame(
            $data['id'],
            $appoint->id,
            '"id" was not set correctly'
        );

        $this->assertSame(
            $data['reason'],
            $appoint->reason,
            '"appointment reason" was not set correctly'
        );

        $this->assertSame(
            $data['startTime'],
            $appoint->startTime,
            '"start time" was not set correctly'
        );

        $this->assertSame(
            $data['endTime'],
            $appoint->endTime,
            '"endTime" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $appoint= new Appoint();

        $appoint->exchangeArray([
            'patientName' => 'some patient name',
            'id'     => 123,
            'reason'  => 'appointment reason',
            'startTime'  => 'start time',
            'endTime'  => 'app',

        ]);
        $appoint->exchangeArray([]);

        $this->assertNull($appoint->patientName, '"patientName" should default to null');
        $this->assertNull($appoint->id, '"id" should default to null');
        $this->assertNull($appoint->reason, '"appointment reason" should default to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $appoint = new Appoint();
        $data  = [
            'patientName' => 'some patient name',
            'id'     => 123,
            'reason'  => 'appointment reason'
        ];

        $appoint->exchangeArray($data);
        $copyArray = $appoint->getArrayCopy();

        $this->assertSame($data['patientName'], $copyArray['patientName'], '"patientName" was not set correctly');
        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
        $this->assertSame($data['reason'], $copyArray['reason'], '"reason" was not set correctly');
    }

    public function testInputFiltersAreSetCorrectly()
    {
        $appoint= new Appoint();

        $inputFilter = $appoint->getInputFilter();

        $this->assertSame(3, $inputFilter->count());
        $this->assertTrue($inputFilter->has('patientName'));
        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('reason'));
    }
}