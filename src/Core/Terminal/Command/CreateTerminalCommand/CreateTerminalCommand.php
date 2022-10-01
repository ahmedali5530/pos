<?php 

namespace App\Core\Terminal\Command\CreateTerminalCommand;

class CreateTerminalCommand
{
    /**
     * @var null|string
     */
    private $code = null;

    /**
     * @var null|string
     */
    private $description = null;

    public function setCode(?string $code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
