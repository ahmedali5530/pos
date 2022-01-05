<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
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

        for($i=1; $i<=1000; $i++){
            $product = new Product();
            $product->setName($this->faker->name());
            $product->setBarcode($this->faker->randomNumber());
            $product->setBasePrice($this->faker->randomNumber(4));
            $product->setIsAvailable(true);
            $product->setQuantity(1000);
            $product->setSku($this->faker->randomNumber());
            $product->setBaseQuantity(1);
            $product->setUom('G');
            $product->setShortCode($i);
            $product->setCategory($category);

            $manager->persist($product);

            if($i % 2 === 0) {
                $color = $this->faker->colorName;
                $productVariant = new ProductVariant();
                $productVariant->setName($color);
                $productVariant->setColor($color);
                $productVariant->setPrice($this->faker->randomNumber(4));
                $productVariant->setProduct($product);

                $manager->persist($productVariant);
            }else if($i % 3  === 0){
                $size = $this->faker->randomNumber(4);
                $productVariant = new ProductVariant();
                $productVariant->setName($size);
                $productVariant->setSize($size);
                $productVariant->setPrice(null);
                $productVariant->setProduct($product);

                $manager->persist($productVariant);
            }else if($i % 7 === 0){
                $weight = $this->faker->randomNumber(4);
                $productVariant = new ProductVariant();
                $productVariant->setName($weight);
                $productVariant->setWeight($weight);
                $productVariant->setPrice(null);
                $productVariant->setProduct($product);

                $manager->persist($productVariant);
            }
        }

        $manager->flush();
    }
}
