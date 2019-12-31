<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        for ($i=0; $i<150; $i++){
            $faker = Faker\Factory::create();
            $title = $faker->title();
            $sumary = $faker->text();
            $episode = new Episode();
            $ref=0;
            foreach (ProgramFixtures::PROGRAMS as $program => $data){
                $episode->setProgram($this->getReference('program_'.$ref));
                $episode->setTitle($title);
                $episode->setSummary($sumary);
                $episode->setSaison($this->getReference('saison_'.rand(1,4)));
                $slugify = new Slugify();
                $slug = $slugify->generate($episode->getTitle());
                $episode->setSlug($slug);
                $ref++;
                $manager->persist($episode);
            }
            $manager->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [ProgramFixtures::class, SaisonFixtures::class];
    }
}