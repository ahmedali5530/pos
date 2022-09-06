<?php

namespace App\Core\Dto\Common\Common;

use App\Entity\Media;

class MediaDto
{
    use IdDtoTrait;
    use NameDtoTrait;

    /**
     * @var string|null
     */
    private $originalName;

    /**
     * @var string|null
     */
    private $extension;

    /**
     * @var string|null
     */
    private $mimeType;

    /**
     * @return string|null
     */
    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    /**
     * @param string|null $originalName
     */
    public function setOriginalName(?string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @param string|null $extension
     */
    public function setExtension(?string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string|null
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * @param string|null $mimeType
     */
    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public static function createFromMedia(?Media $media): ?self
    {
        if($media === null){
            return null;
        }

        $dto = new self();

        $dto->id = $media->getId();
        $dto->name = $media->getName();
        $dto->originalName = $media->getOriginalName();
        $dto->extension = $media->getExtension();
        $dto->mimeType = $media->getMimeType();


        return $dto;
    }

}
