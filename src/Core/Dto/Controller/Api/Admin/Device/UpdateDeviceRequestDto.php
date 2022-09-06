<?php 

namespace App\Core\Dto\Controller\Api\Admin\Device;

use App\Core\Device\Command\UpdateDeviceCommand\UpdateDeviceCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateDeviceRequestDto
{
    /**
     * @var null|int
     */
    private $id = null;

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

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->ipAddress = $data['ipAddress'] ?? null;
        $dto->port = $data['port'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->prints = $data['prints'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateDeviceCommand $command)
    {
        $command->setId($this->id);
        $command->setIpAddress($this->ipAddress);
        $command->setPort($this->port);
        $command->setName($this->name);
        $command->setPrints($this->prints);
    }
}
