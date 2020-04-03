<?php


namespace Evrinoma\EximBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * Interface EximFixtureInterface
 *
 * @package Evrinoma\EximBundle\DataFixtures
 */
interface EximFixtureInterface extends FixtureGroupInterface
{
    public function create();
}