<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORY = [
        'horeur',
        'action',
        'comedie',
        'science-fiction',
        'aventure',
        'suspens'
    ];

    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        foreach (self::CATEGORY as $key => $categorie){
            $category = new Category();
            $category->setName($categorie);
            $manager->persist($category);
            $this->addReference('category_'.$key, $category);
    }
        $manager->flush();
    }
}