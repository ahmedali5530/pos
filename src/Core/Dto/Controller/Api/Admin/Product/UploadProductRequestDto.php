<?php


namespace App\Core\Dto\Controller\Api\Admin\Product;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UploadProductRequestDto
{
    /**
     * @var File|null
     */
    private $file;

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    public static function createFromRequest(Request $request): self
    {
        $dto = new self();

        $dto->file = $request->files->get('file');

        return $dto;
    }

}