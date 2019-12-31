<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Service\Slugify;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        for ($i=0; $i<50; $i++){
            $actor = new Actor();
            $faker = Faker\Factory::create('fr_FR');
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program_'.rand(0,5)));
            $slugify = new Slugify();
            $slug = ($slugify->generate($actor->getName()));
            $actor->setSlug($slug);
            $manager->persist($actor);
            $i++;
        }
        $manager->flush();

    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [ProgramFixtures::class];
    }
}