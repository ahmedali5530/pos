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

        for($i=1; $i<=10; $i++){
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

            $this->setReference('product', $product);
        }

        $colors = ['Blue', 'White', 'Gray', 'Pink'];
        foreach($colors as $color){
            $productVariant = new ProductVariant();
            $productVariant->setName($color);
            $productVariant->setColor($color);
            $productVariant->setPrice($this->faker->randomNumber(4));
            $productVariant->setProduct($this->getReference('product'));

            $manager->persist($productVariant);
        }

        $manager->flush();
    }
}
