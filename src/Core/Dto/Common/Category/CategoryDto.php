<?php


namespace App\Core\Dto\Common\Category;


use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Entity\Category;

class CategoryDto
{
    use ActiveDtoTrait;
    use UuidDtoTrait;
    use TimestampsDtoTrait;
    use StoresDtoTrait;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var CategoryDto|null
     */
    private $parent;

    /**
     * @var CategoryDto[]
     */
    private $children = [];

    public static function createFromCategory(?Category $category): ?self
    {
        if($category === null){
            return null;
        }

        $dto = new self();
        $dto->id = $category->getId();
        $dto->name = $category->getName();
        $dto->type = $category->getType();
        $dto->parent = CategoryDto::createFromCategory($category->getParent());
        foreach($category->getChildren() as $child){
            $dto->children[] = CategoryDto::createFromCategory($child);
        }

        $dto->uuid = $category->getUuid();
        $dto->isActive = $category->getIsActive();
        $dto->createdAt = DateTimeDto::createFromDateTime($category->getCreatedAt());

        $dto->setStores($category->getStores());

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->type = $data['type'] ?? null;
        $dto->parent = CategoryDto::createFromArray($data['parent'] ?? null);
        foreach($data['children'] ?? [] as $child){
            $dto->children[] = CategoryDto::createFromArray($child);
        }

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return CategoryDto|null
     */
    public function getParent(): ?CategoryDto
    {
        return $this->parent;
    }

    /**
     * @param CategoryDto|null $parent
     */
    public function setParent(?CategoryDto $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return CategoryDto[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param CategoryDto[] $children
     */
    public function setChildren(array $children): void
    {
        $this->children = $children;
    }
}
