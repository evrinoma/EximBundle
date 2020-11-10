<?php


namespace Evrinoma\EximBundle\Manager;

use Evrinoma\EximBundle\Dto\DomainDto;
use Evrinoma\EximBundle\Entity\Domain;
use Evrinoma\EximBundle\Vuetable\VuetableInterface;
use Evrinoma\UtilsBundle\Manager\EntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * Interface DomainManagerInterface
 *
 * @package Evrinoma\EximBundle\Manager
 */
interface DomainManagerInterface extends RestInterface, EntityInterface
{

//region SECTION: Public
    /**
     * @param DomainDto $domainDto
     *
     * @return Domain
     * @throws \Exception
     */
    public function toSave(DomainDto $domainDto);
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param DomainDto|null $domainDto
     *
     * @return VuetableInterface
     */
    public function get(?DomainDto $domainDto);
//endregion Getters/Setters

}