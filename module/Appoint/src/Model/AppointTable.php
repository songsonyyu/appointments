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

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

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

    public function deleteAppoint($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}