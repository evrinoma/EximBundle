<?php


namespace Evrinoma\EximBundle\Manager;

use Evrinoma\EximBundle\Dto\SpamDto;
use Evrinoma\UtilsBundle\Manager\BaseEntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * Interface SpamManagerInterface
 *
 * @package Evrinoma\EximBundle\Manager
 */
interface SpamManagerInterface extends RestInterface, BaseEntityInterface
{
//region SECTION: Public
    public function toSave(SpamDto $spamDto);
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param SpamDto $spamDto
     *
     * @return SpamManager
     */
    public function get(?SpamDto $spamDto): SpamManagerInterface;

    /**
     * @param SpamDto $spamDto
     *
     * @return $this
     */
    public function getType(SpamDto $spamDto): SpamManagerInterface;

    /**
     * @param SpamDto $spamDto
     *
     * @return $this
     */
    public function getConformity(SpamDto $spamDto): SpamManagerInterface;
//endregion Getters/Setters
}