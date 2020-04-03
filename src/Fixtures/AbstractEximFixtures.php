<?php


namespace Evrinoma\EximBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AbstractEximFixtures
 *
 * @package Evrinoma\EximBundle\DataFixtures
 */
abstract class AbstractEximFixtures extends Fixture implements EximFixtureInterface
{
//region SECTION: Fields
    /**
     * @var ObjectManager
     */
    protected $objectManager;
//endregion Fields

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->objectManager = $manager;

        $this->create();

       // $this->objectManager->flush();
    }
}