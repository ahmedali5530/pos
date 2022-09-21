<?php

namespace App\Core\Product\Command\CreateProductCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductPrice;
use App\Entity\ProductVariant;
use App\Entity\Store;
use App\Entity\Supplier;
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

        $item = new Product();
        $item->setName($command->getName());
        $item->setSku($command->getSku());
        $item->setBarcode($command->getBarcode());
        $item->setBaseQuantity($command->getBaseQuantity());
        $item->setIsAvailable($command->getIsAvailable());
        $item->setBasePrice($command->getBasePrice());
        $item->setQuantity($command->getQuantity());
        $item->setCost($command->getCost());
        $item->setSaleUnit($command->getSaleUnit());
        $item->setPurchaseUnit($command->getPurchaseUnit());

        if($command->getCategories() !== null){
            foreach($command->getCategories() as $category){
                $c = $this->getRepository(Category::class)->find($category);
                $item->addCategory($c);
            }
        }

        if($command->getBrands() !== null){
            foreach($command->getBrands() as $brand){
                $b = $this->getRepository(Brand::class)->find($brand);
                $item->addBrand($b);
            }
        }

        if($command->getSuppliers() !== null){
            foreach($command->getSuppliers() as $supplier){
                $s = $this->getRepository(Supplier::class)->find($supplier);
                $item->addSupplier($s);
            }
        }

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }

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
