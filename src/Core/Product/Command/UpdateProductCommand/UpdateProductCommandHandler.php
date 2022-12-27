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
use App\Entity\Tax;
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

        $item->setBaseQuantity($command->getBaseQuantity());
        $item->setIsAvailable($command->getIsAvailable());
        $item->setBasePrice($command->getBasePrice());
        $item->setQuantity($command->getQuantity());
        $item->setSaleUnit($command->getSaleUnit());
        $item->setPurchaseUnit($command->getPurchaseUnit());
        $item->setCost($command->getCost());

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

        if($command->getTaxes() !== null){
            foreach($item->getTaxes() as $tax){
                $item->removeTax($tax);
            }

            foreach($command->getTaxes() as $tax){
                $t = $this->getRepository(Tax::class)->find($tax);
                $item->addTax($t);
            }
        }

        $prevVariants = [];
        foreach($item->getVariants() as $variant){
            $prevVariants[] = $variant->getId();
        }

        $updatedVariants = [];
        if($command->getVariants() !== null){
            foreach($command->getVariants() as $variant){
                if($variant->getId() !== null){
                    $updatedVariants[] = $variant->getId();

                    $v = $this->getRepository(ProductVariant::class)->find($variant->getId());

                    $v->setName($item->getName());
                    $v->setAttributeValue($variant->getAttributeValue());
                    $v->setPrice($variant->getPrice());
                    $v->setBarcode($variant->getBarcode());
                    $v->setProduct($item);

                    $this->persist($v);
                }else {
                    $v = new ProductVariant();
                    $v->setName($item->getName());
                    $v->setAttributeValue($variant->getAttributeValue());
                    $v->setPrice($variant->getPrice());
                    $v->setBarcode($variant->getBarcode());
                    $v->setProduct($item);

                    $this->persist($v);

                    $item->addVariant($v);
                }
            }
        }

        //remove non-persisted items
        $nonPersistedVariants = array_diff($prevVariants, $updatedVariants);
        if(count($nonPersistedVariants) > 0){
            $variants = $this->getRepository(ProductVariant::class)->findBy([
                'id' => $nonPersistedVariants
            ]);

            try {
                $this->removeAll($variants);
            }catch (\Exception $exception){
                return UpdateProductCommandResult::createFromValidationErrorMessage('Error while removing variants!');
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
