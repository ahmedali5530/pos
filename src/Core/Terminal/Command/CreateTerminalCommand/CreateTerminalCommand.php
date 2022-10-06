<?php

namespace App\Core\Terminal\Command\CreateTerminalCommand;

use App\Core\Dto\Common\Common\StoreDtoTrait;

class CreateTerminalCommand
{
    use StoreDtoTrait;

    /**
     * @var null|string
     */
    private $code = null;

    /**
     * @var null|string
     */
    private $description = null;

    /**
     * @var int[]|null
     */
    private $products;

    /**
     * @var int[]|null
     */
    private $excludeProducts;

    /**
     * @var int[]|null
     */
    private $categories;

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

    /**
     * @return int[]|null
     */
    public function getProducts(): ?array
    {
        return $this->products;
    }

    /**
     * @param int[]|null $products
     */
    public function setProducts(?array $products): void
    {
        $this->products = $products;
    }

    /**
     * @return int[]|null
     */
    public function getExcludeProducts(): ?array
    {
        return $this->excludeProducts;
    }

    /**
     * @param int[]|null $excludeProducts
     */
    public function setExcludeProducts(?array $excludeProducts): void
    {
        $this->excludeProducts = $excludeProducts;
    }

    /**
     * @return int[]|null
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * @param int[]|null $categories
     */
    public function setCategories(?array $categories): void
    {
        $this->categories = $categories;
    }
}
