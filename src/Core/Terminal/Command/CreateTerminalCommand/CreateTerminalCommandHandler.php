<?php

namespace App\Core\Terminal\Command\CreateTerminalCommand;

use App\Entity\Product;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Terminal;

class CreateTerminalCommandHandler extends EntityManager implements CreateTerminalCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateTerminalCommand $command) : CreateTerminalCommandResult
    {
        $item = new Terminal();

        $item->setCode($command->getCode());
        $item->setDescription($command->getDescription());
        $item->setStore($this->getRepository(Store::class)->find($command->getStore()));

        if($command->getProducts() !== null || $command->getCategories() !== null || $command->getExcludeProducts() !== null){
            //remove all previous products
            foreach($item->getProducts() as $product){
                $item->removeProduct($product);
            }

            $qb = $this->createQueryBuilder('product', Product::class);

            if($command->getProducts() !== null){
                $qb->andWhere('product.id IN (:productIds)')->setParameter('productIds', $command->getProducts());
            }

            if($command->getCategories() !== null){
                $qb->join('product.categories', 'category');
                $qb->andWhere('category.id IN (:categoryIds)')->setParameter('categoryIds', $command->getCategories());
            }

            if($command->getExcludeProducts() !== null){
                $qb->andWhere('product.id NOT IN (:excludeProductIds)')->setParameter('excludeProductIds', $command->getExcludeProducts());
            }

            $products = $qb->getQuery()->getResult();

            foreach($products as $product){
                $item->addProduct($product);
            }
        }

        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateTerminalCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateTerminalCommandResult();
        $result->setTerminal($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Terminal::class;
    }
}
