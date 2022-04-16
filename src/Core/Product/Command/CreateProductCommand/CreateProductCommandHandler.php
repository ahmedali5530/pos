<?php

namespace App\Core\Product\Command\CreateProductCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductPrice;
use App\Entity\ProductVariant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateProductCommandHandler extends EntityManager implements CreateProductCommandHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateProductCommand $command): CreateProductCommandResult
    {
        //validate prices
        $prices = [];
        if($command->getPrices() !== null){
            foreach($command->getPrices() as $priceId){
                $price = $this->getRepository(ProductPrice::class)->find($priceId);
                if($price === null){
                    return CreateProductCommandResult::createNotFound('Product Price with ID "'.$priceId.'" not found');
                }

                $prices[] = $price;
            }
        }

        $variants = [];
        if($command->getVariants() !== null){
            foreach($command->getVariants() as $variantId){
                $variant = $this->getRepository(ProductVariant::class)->find($variantId);
                if($variant === null){
                    return CreateProductCommandResult::createNotFound('Product Variant with ID "'.$variantId.'" not found');
                }

                $variants[] = $variant;
            }
        }

        /** @var Category $category */
        $category = $this->getRepository(Category::class)->find($command->getCategory());
        if($category === null){
            return CreateProductCommandResult::createNotFound('Category with ID "'.$command->getCategory().'" not found');
        }

        $item = new Product();
        $item->setName($command->getName());
        $item->setSku($command->getSku());
        $item->setBarcode($command->getBarcode());
        $item->setBaseQuantity($command->getBaseQuantity());
        $item->setIsAvailable($command->getIsAvailable());
        $item->setBasePrice($command->getBasePrice());
        $item->setQuantity($command->getQuantity());
        $item->setUom($command->getUom());
        $item->setShortCode($command->getShortCode());
        $item->setCategory($category);
        $item->setCost($command->getCost());

        foreach($prices as $price){
            $item->addPrice($price);
        }

        foreach($variants as $variant){
            $item->addVariant($variant);
        }

        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateProductCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateProductCommandResult();
        $result->setProduct($item);

        return $result;
    }
}