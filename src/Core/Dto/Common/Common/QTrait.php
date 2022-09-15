<?php


namespace App\Core\Dto\Common\Common;


trait QTrait
{
    /**
     * @var string|null
     */
    private $q;

    /**
     * @return string|null
     */
    public function getQ(): ?string
    {
        return $this->q;
    }

    /**
     * @param string|null $q
     */
    public function setQ(?string $q): void
    {
        $this->q = $q;
    }
}
