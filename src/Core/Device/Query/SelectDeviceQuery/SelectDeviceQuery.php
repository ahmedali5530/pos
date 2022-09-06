<?php 

namespace App\Core\Device\Query\SelectDeviceQuery;

class SelectDeviceQuery
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

    /**
     * @var null|int
     */
    private $limit = null;

    /**
     * @var null|int
     */
    private $offset = null;

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

    public function setLimit(?int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setOffset(?int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }
}
