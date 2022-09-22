<?php

namespace App\Core\Dto\Controller\Api\Admin\Closing;

use App\Core\Dto\Common\Closing\ClosingDto;
use App\Entity\Closing;

class SelectClosingResponseDto
{
    /**
     * @var ClosingDto
     */
    private $closing = null;

    public static function createFromClosing(Closing $closing) : self
    {
        $dto = new self();

        $dto->closing = ClosingDto::createFromClosing($closing);

        return $dto;
    }

    public function setClosing($closing)
    {
        $this->closing = $closing;
    }

    public function getClosing()
    {
        return $this->closing;
    }
}
