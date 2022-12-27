<?php

namespace App\Core\Dto\Controller\Api\Admin\Terminal;

use App\Core\Dto\Common\Common\StoreDtoTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Terminal\Command\CreateTerminalCommand\CreateTerminalCommand;
use App\Core\Validation\Custom\ConstraintValidEntity;

class CreateTerminalRequestDto
{
    use StoreDtoTrait;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $code = null;

    /**
     * @var null|string
     */
    private $description = null;

    /**
     * @var int[]|null
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Product", entityName="Product")
     * )
     */
    private $products;

    /**
     * @var int[]|null
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Product", entityName="Product")
     * )
     */
    private $excludeProducts;

    /**
     * @var int[]|null
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Category", entityName="Category")
     * )
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->code = $data['code'] ?? null;
        $dto->description = $data['description'] ?? null;
        $dto->store = $data['store'] ?? null;

        $dto->products = $data['products'] ?? null;
        $dto->categories = $data['categories'] ?? null;
        $dto->excludeProducts = $data['excludeProducts'] ?? null;

        if($dto->products === []){
            $dto->products = null;
        }

        return $dto;
    }

    public function populateCommand(CreateTerminalCommand $command)
    {
        $command->setCode($this->code);
        $command->setDescription($this->description);
        $command->setStore($this->store);

        $command->setProducts($this->products);
        $command->setExcludeProducts($this->excludeProducts);
        $command->setCategories($this->categories);
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
