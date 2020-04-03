<?php


namespace Evrinoma\EximBundle\Manager;


use Evrinoma\UtilsBundle\Manager\BaseEntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * Interface SearchManagerInterface
 *
 * @package Evrinoma\EximBundle\Manager
 */
interface SearchManagerInterface extends RestInterface, BaseEntityInterface
{
//region SECTION: Public
    public function saveSettings();
//endregion Public

//region SECTION: Dto
    public function setDto($dto): SearchManagerInterface;
//endregion SECTION: Dto

//region SECTION: Getters/Setters

    /**
     * @return array
     */
    public function getSettings(): array;

    /**
     * @return array
     */
    public function getResult(): array;

    /**
     * @return array
     */
    public function getSearchResult(): array;

    /**
     * @return $this
     */
    public function getSearch(): SearchManagerInterface;
}