<?php 

namespace App\Core\Dto\Controller\Api\Admin\Discount;

use App\Core\Discount\Query\GetDiscountListQuery\GetDiscountListQuery;
use Symfony\Component\HttpFoundation\Request;

class DiscountListRequestDto
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getLimit() : ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit) : void
    {
        $this->limit = $limit;
    }

    /**
     * @return int|null
     */
    public function getOffset() : ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     */
    public function setOffset(?int $offset) : void
    {
        $this->offset = $offset;
    }

    public static function createFromRequest(Request $request)
    {
        $dto = new self();

        $dto->name = $request->query->get('name');
        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');

        return $dto;
    }

    public function populateQuery(GetDiscountListQuery $query)
    {
        $query->setName($this->name);
        $query->setLimit($this->limit);
        $query->setOffset($this->offset);
    }
}
