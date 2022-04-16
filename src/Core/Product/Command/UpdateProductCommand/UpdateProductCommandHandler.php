<?php

namespace App\Core\Product\Command\UpdateProductCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Core\Product\Command\CreateProductCommand\CreateProductCommandResult;
use App\Entity\Product;
use App\Entity\ProductPrice;
use App\Entity\ProductVariant;
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
                $price = $this->getRepository(ProductPrice::class)->find($priceId);
                if($price === null){
                    return UpdateProductCommandResult::createNotFound('Product Price with ID "'.$priceId.'" not found');
                }

                $prices[] = $price;
            }
        }

        $variants = [];
        if($command->getVariants() !== null){
            foreach($command->getVariants() as $variantId){
                $variant = $this->getRepository(ProductVariant::class)->find($variantId);
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
        if ($command->getUom() !== null) {
            $item->setUom($command->getUom());
        }
        if ($command->getShortCode() !== null) {
            $item->setShortCode($command->getShortCode());
        }
        if($command->getCost() !== null){
            $item->setCost($command->getCost());
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
            return UpdateProductCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateProductCommandResult();
        $result->setProduct($item);

        return $result;
    }
}