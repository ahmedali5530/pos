<?php

namespace App\Core\Dto\Controller\Api\Admin\Terminal;

use App\Core\Terminal\Command\UpdateTerminalCommand\UpdateTerminalCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateTerminalRequestDto
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $code = null;

    /**
     * @var null|string
     */
    private $description = null;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->code = $data['code'] ?? null;
        $dto->description = $data['description'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateTerminalCommand $command)
    {
        $command->setId($this->id);
        $command->setCode($this->code);
        $command->setDescription($this->description);
    }
}
