<?php


namespace App\Core\Dto\Common\Device;


use App\Entity\Device;

class DeviceDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var int
     */
    private $port;

    /**
     * @var int
     */
    private $prints;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return int
     */
    public function getPrints(): int
    {
        return $this->prints;
    }

    /**
     * @param int $prints
     */
    public function setPrints(int $prints): void
    {
        $this->prints = $prints;
    }

    public static function createFromDevice(Device $device): self
    {
        $dto = new self();
        $dto->id = $device->getId();
        $dto->ipAddress = $device->getIpAddress();
        $dto->port = $device->getPort();
        $dto->name = $device->getName();
        $dto->prints = $device->getPrints();

        return $dto;
    }
}