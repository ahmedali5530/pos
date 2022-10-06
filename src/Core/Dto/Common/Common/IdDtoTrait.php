<?php


namespace App\Core\Dto\Common\Common;


use Symfony\Component\Serializer\Annotation\Groups;

trait IdDtoTrait
{
    /**
     * @var int;
     */
    private $id;

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
}
