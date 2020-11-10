<?php


namespace Evrinoma\EximBundle\Manager;

use Evrinoma\EximBundle\Dto\ServerDto;
use Evrinoma\UtilsBundle\Manager\EntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * Interface ServerManagerInterface
 *
 * @package Evrinoma\EximBundle\Manager
 */
interface ServerManagerInterface extends RestInterface, EntityInterface
{
//region SECTION: Public
    /**
     * @param ServerDto $serverDto
     *
     * @return mixed
     */
    public function toSave(ServerDto $serverDto);
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param ServerDto $serverDto
     *
     * @return $this
     */
    public function get(?ServerDto $serverDto): ServerManagerInterface;
//endregion Getters/Setters
}