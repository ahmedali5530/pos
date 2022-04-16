<?php 

namespace App\Core\Dto\Controller\Api\Admin\Category;

use App\Core\Category\Command\UpdateCategoryCommand\UpdateCategoryCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateCategoryRequestDto
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
     */
    private $type = null;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->type = $data['type'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateCategoryCommand $command)
    {
        $command->setId($this->id);
        $command->setName($this->name);
        $command->setType($this->type);
    }
}
