<?php 

namespace App\Core\Dto\Controller\Api\Admin\Device;

use App\Core\Dto\Common\Device\DeviceDto;
use App\Entity\Device;

class SelectDeviceResponseDto
{
    /**
     * @var DeviceDto
     */
    private $device = null;

    public static function createFromDevice(Device $device) : self
    {
        $dto = new self();

        $dto->device = DeviceDto::createFromDevice($device);

        return $dto;
    }

    public function setDevice($device)
    {
        $this->device = $device;
    }

    public function getDevice()
    {
        return $this->device;
    }
}
