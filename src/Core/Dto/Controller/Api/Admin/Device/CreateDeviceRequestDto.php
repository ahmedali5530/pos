<?php 

namespace App\Core\Dto\Controller\Api\Admin\Device;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Device\Command\CreateDeviceCommand\CreateDeviceCommand;

class CreateDeviceRequestDto
{
    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $ipAddress = null;

    /**
     * @var null|int
     * @Assert\NotBlank(normalizer="trim")
     */
    private $port = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $name = null;

    /**
     * @var null|int
     * @Assert\NotBlank(normalizer="trim")
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->ipAddress = $data['ipAddress'] ?? null;
        $dto->port = $data['port'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->prints = $data['prints'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateDeviceCommand $command)
    {
        $command->setIpAddress($this->ipAddress);
        $command->setPort($this->port);
        $command->setName($this->name);
        $command->setPrints($this->prints);
    }
}
