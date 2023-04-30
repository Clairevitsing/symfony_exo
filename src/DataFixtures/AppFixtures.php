<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_CATEGORIES = 10;
    private const NB_PRODUCTS = 150;
    private const NB_CONTACTS = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // $product = new Product();
        for ($i = 0, $categories = []; $i < self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category
                ->setTitle($faker->unique()->word())
                ->setDescription($faker->realTextBetween(50, 100));
            $manager->persist($category);
            $categories[] = $category;
        }


        for ($i = 0; $i < self::NB_PRODUCTS; $i++) {
            $product = new Product();

            $product
                ->setName($faker->unique()->word())
                ->setDescription($faker->realTextBetween(400, 800))
                #->setPbt($faker->numberBetween($min = 0.01, $max = 199.99))
                ->setPbt($faker->randomfloat(2, 5, 100))
                ->setVisible($faker->boolean())
                ->setOnSale($faker->boolean())
                ->setDateCreated($faker->dateTimeBetween('-3 years'))
                ->setCategory($faker->randomElement($categories));

            $manager->persist($product);
        }

        //contact
        for ($i = 0; $i < self::NB_CONTACTS; $i++) {

            $contact = new Contact();
            $contact->setFullName($faker->name())
                ->setEmail($faker->email())
                ->setSubject('Demande n°' . ($i + 1))
                ->setMessage($faker->text())
                ->setCreatedAt($faker->dateTimeBetween('-3 years'));

            $manager->persist($contact);
        }
        $manager->flush();
    }
}
