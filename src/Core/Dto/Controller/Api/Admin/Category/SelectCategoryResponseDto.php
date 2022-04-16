<?php 

namespace App\Core\Dto\Controller\Api\Admin\Category;

use App\Core\Dto\Common\Category\CategoryDto;
use App\Entity\Category;

class SelectCategoryResponseDto
{
    /**
     * @var CategoryDto
     */
    private $category = null;

    public static function createFromCategory(Category $category) : self
    {
        $dto = new self();

        $dto->category = CategoryDto::createFromCategory($category);

        return $dto;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }
}
