<?php

namespace Appoint\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class AppointTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    // Retrieves all appointment rows from the database
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    // Retrieves a single row as an Appointment object
    public function getAppoint($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    // Creates a new row in the database or updates a row that already exists
    public function saveAppoint(Appoint $appoint)
    {
        $data = [
            'patientName' => $appoint->patientName,
            'reason'  => $appoint->reason,
            'startTime'  => $appoint->startTime,
            'endTime'  => $appoint->endTime
        ];

        $id = (int) $appoint->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getAppoint($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update appintment with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    // Removes the row completely.
    public function deleteAppoint($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}