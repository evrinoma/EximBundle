<?php


namespace Evrinoma\EximBundle\Manager;

use Evrinoma\EximBundle\Dto\AclDto;
use Evrinoma\EximBundle\Entity\Acl;
use Evrinoma\UtilsBundle\Manager\EntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

interface AclManagerInterface extends RestInterface, EntityInterface
{

//region SECTION: Public
    /**
     * @param AclDto $aclDto
     *
     * @return Acl
     * @throws \Exception
     */
    public function toSave(AclDto $aclDto);
//endregion Public
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param AclDto $aclDto
     *
     * @return $this
     */
    public function get(?AclDto $aclDto): AclManagerInterface;

    /**
     * @return $this
     */
    public function getModel(): AclManagerInterface;
}