<?php 

namespace App\Core\Dto\Controller\Api\Admin\Device;

use App\Core\Device\Query\SelectDeviceQuery\SelectDeviceQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectDeviceRequestDto
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

        $dto->id = $request->query->get('id');
        $dto->ipAddress = $request->query->get('ipAddress');
        $dto->port = $request->query->get('port');
        $dto->name = $request->query->get('name');
        $dto->prints = $request->query->get('prints');


        return $dto;
    }

    public function populateQuery(SelectDeviceQuery $query)
    {
        $query->setId($this->id);
        $query->setIpAddress($this->ipAddress);
        $query->setPort($this->port);
        $query->setName($this->name);
        $query->setPrints($this->prints);
    }
}
