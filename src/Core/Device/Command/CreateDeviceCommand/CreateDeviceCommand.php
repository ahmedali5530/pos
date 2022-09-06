<?php 

namespace App\Core\Device\Command\CreateDeviceCommand;

class CreateDeviceCommand
{
    /**
     * @var null|string
     */
    private $ipAddress = null;

    /**
     * @var null|int
     */
    private $port = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|int
     */
    private $prints = null;

    public function setIpAddress(?string $ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    public function setPort(?int $port)
    {
        $this->port = $port;
        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrints(?int $prints)
    {
        $this->prints = $prints;
        return $this;
    }

    public function getPrints()
    {
        return $this->prints;
    }
}
