<?php

namespace App\DataFixtures;

use App\Entity\Saison;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SaisonFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        for ($i = 1; $i < 5; $i++) {
            $saison = new Saison();
            $saison->setNum($i);
            $saison->setProgram($this->getReference('program_'.rand(0,5)));
            $manager->persist($saison);
            $this->addReference('saison_'.$i, $saison);
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