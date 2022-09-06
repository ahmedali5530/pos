<?php


namespace App\Core\Dto\Common\Common;


trait MediaDtoTrait
{
    /**
     * @var MediaDto|null;
     */
    private $media;

    /**
     * @return MediaDto|null
     */
    public function getMedia(): ?MediaDto
    {
        return $this->media;
    }

    /**
     * @param MediaDto|null $media
     */
    public function setMedia(?MediaDto $media): void
    {
        $this->media = $media;
    }
}
