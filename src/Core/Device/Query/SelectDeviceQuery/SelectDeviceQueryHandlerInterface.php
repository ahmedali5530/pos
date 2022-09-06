<?php 

namespace App\Core\Device\Query\SelectDeviceQuery;

interface SelectDeviceQueryHandlerInterface
{
    public function handle(SelectDeviceQuery $command) : SelectDeviceQueryResult;
}
