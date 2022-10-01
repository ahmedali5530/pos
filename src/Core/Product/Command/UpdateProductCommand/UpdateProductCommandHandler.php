<?php

namespace App\Core\Product\Command\UpdateProductCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Core\Product\Command\CreateProductCommand\CreateProductCommandResult;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Department;
use App\Entity\Product;
use App\Entity\ProductPrice;
use App\Entity\ProductVariant;
use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateProductCommandHandler extends EntityManager implements UpdateProductCommandHandlerInterface
{
    protected function getEntityClass(): string
    {
        return product::class;
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

    public function handle(UpdateProductCommand $command): UpdateProductCommandResult
    {
        //validate prices
        $prices = [];
        if($command->getPrices() !== null){
            foreach($command->getPrices() as $priceId){
                $price = $this->getRepository(ProductPrice::class)->find($priceId->getId());
                if($price === null){
                    return UpdateProductCommandResult::createNotFound('Product Price with ID "'.$priceId.'" not found');
                }

                $prices[] = $price;
            }
        }

        $variants = [];
        if($command->getVariants() !== null){
            foreach($command->getVariants() as $variantId){
                $variant = $this->getRepository(ProductVariant::class)->find($variantId->getId());
                if($variant === null){
                    return UpdateProductCommandResult::createNotFound('Product Variant with ID "'.$variantId.'" not found');
                }

                $variants[] = $variant;
            }
        }

        /** @var Product $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateProductCommandResult::createNotFound();
        }
        if ($command->getName() !== null) {
            $item->setName($command->getName());
        }
        if ($command->getSku() !== null) {
            $item->setSku($command->getSku());
        }
        if ($command->getBarcode() !== null) {
            $item->setBarcode($command->getBarcode());
        }
        if ($command->getBaseQuantity() !== null) {
            $item->setBaseQuantity($command->getBaseQuantity());
        }
        if ($command->getIsAvailable() !== null) {
            $item->setIsAvailable($command->getIsAvailable());
        }
        if ($command->getBasePrice() !== null) {
            $item->setBasePrice($command->getBasePrice());
        }
        if ($command->getQuantity() !== null) {
            $item->setQuantity($command->getQuantity());
        }
        if($command->getSaleUnit() !== null) {
            $item->setSaleUnit($command->getSaleUnit());
        }
        if($command->getPurchaseUnit() !== null) {
            $item->setPurchaseUnit($command->getPurchaseUnit());
        }
        if($command->getCost() !== null){
            $item->setCost($command->getCost());
        }

        $item->setDepartment($this->getRepository(Department::class)->find($command->getDepartment()));

        if($command->getCategories() !== null){
            //remove categories first
            foreach($item->getCategories() as $category){
                $item->removeCategory($category);
            }

            foreach($command->getCategories() as $category){
                $c = $this->getRepository(Category::class)->find($category);
                $item->addCategory($c);
            }
        }

        if($command->getBrands() !== null){
            foreach($item->getBrands() as $brand){
                $item->removeBrand($brand);
            }

            foreach($command->getBrands() as $brand){
                $b = $this->getRepository(Brand::class)->find($brand);
                $item->addBrand($b);
            }
        }

        if($command->getSuppliers() !== null){
            foreach($item->getSuppliers() as $supplier){
                $item->removeSupplier($supplier);
            }

            foreach($command->getSuppliers() as $supplier){
                $s = $this->getRepository(Supplier::class)->find($supplier);
                $item->addSupplier($s);
            }
        }

        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateProductCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateProductCommandResult();
        $result->setProduct($item);

        return $result;
    }
}
