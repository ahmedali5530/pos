<?php

namespace App\Core\Dto\Controller\Api\Admin\Terminal;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Terminal\Command\CreateTerminalCommand\CreateTerminalCommand;

class CreateTerminalRequestDto
{
    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->code = $data['code'] ?? null;
        $dto->description = $data['description'] ?? null;

        return $dto;
    }

    public function populateCommand(CreateTerminalCommand $command)
    {
        $command->setCode($this->code);
        $command->setDescription($this->description);
    }
}
