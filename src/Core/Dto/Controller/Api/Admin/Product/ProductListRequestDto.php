<?php


namespace App\Core\Dto\Controller\Api\Admin\Product;


use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Product\Query\GetProductsListQuery\GetProductsListQuery;
use Symfony\Component\HttpFoundation\Request;

class ProductListRequestDto
{
    use LimitTrait;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $categoryName;

    /**
     * @var int|null
     */
    private $categoryId;

    /**
     * @var float|null
     */
    private $priceFrom;

    /**
     * @var float|null
     */
    private $priceTo;

    public static function createFromRequest(Request $request): self
    {
        $dto = new self();
        $dto->name = $request->query->get('name');
        $dto->categoryName = $request->query->get('categoryName');
        $dto->categoryId = $request->query->get('categoryId');
        $dto->priceFrom = $request->query->get('priceFrom');
        $dto->priceTo = $request->query->get('priceTo');
        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');

        return $dto;
    }

    public function populateQuery(GetProductsListQuery $query)
    {
        $query->setName($this->name);
        $query->setCategoryId($this->categoryId);
        $query->setCategoryName($this->categoryName);
        $query->setPriceFrom($this->priceFrom);
        $query->setPriceTo($this->priceTo);
        $query->setLimit($this->getLimit());
        $query->setOffset($this->getOffset());
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
    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    /**
     * @param string|null $categoryName
     */
    public function setCategoryName(?string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @param int|null $categoryId
     */
    public function setCategoryId(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return float|null
     */
    public function getPriceFrom(): ?float
    {
        return $this->priceFrom;
    }

    /**
     * @param float|null $priceFrom
     */
    public function setPriceFrom(?float $priceFrom): void
    {
        $this->priceFrom = $priceFrom;
    }

    /**
     * @return float|null
     */
    public function getPriceTo(): ?float
    {
        return $this->priceTo;
    }

    /**
     * @param float|null $priceTo
     */
    public function setPriceTo(?float $priceTo): void
    {
        $this->priceTo = $priceTo;
    }
}