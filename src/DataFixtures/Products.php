<?php

namespace App\DataFixtures;

use App\Core\Dto\Common\Department\DepartmentDto;
use App\Entity\Category;
use App\Entity\Department;
use App\Entity\Product;
use App\Entity\ProductPrice;
use App\Entity\ProductVariant;
use App\Factory\Faker\FakerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class Products extends Fixture
{
    /**
     * @var Generator
     */
    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Main');
        $category->setType(Category::TYPE_PRODUCT);
        $manager->persist($category);

        //create department
        $department = new Department();
        $department->setName('Shoes');
        $manager->persist($department);

        for($i=1; $i<=1000; $i++){
            $product = new Product();
            $product->setName($this->faker->name());
            $product->setBarcode($this->faker->randomNumber());
            $product->setBasePrice($this->faker->randomNumber(4));
            $product->setIsAvailable(true);
            $product->setQuantity(1000);
            $product->setSku($this->faker->randomNumber());
            $product->setBaseQuantity(1);
            $product->setPurchaseUnit('G');
            $product->setSaleUnit('G');
            $product->addCategory($category);
            $product->addStore($this->getReference('store'));
            $product->setDepartment($department);

            $manager->persist($product);

            $sizes = [36, 38, 40, 42, 44];

            foreach($sizes as $size){
                $color = $this->faker->colorName;
                $productVariant = new ProductVariant();
                $productVariant->setName($product->getName());
                $productVariant->setAttributeName(sprintf('%s-%s', $this->faker->colorName, $size));
                $productVariant->setAttributeValue(sprintf('%s-%s', $color, $size));
                $productVariant->setProduct($product);
                $manager->persist($productVariant);
            }

            $price = new ProductPrice();
            $price->setProduct($product);
            $price->setBasePrice($this->faker->randomNumber(4));
            $price->setMonth(date('m'));

            $manager->persist($price);
        }

        $manager->flush();
    }
}
