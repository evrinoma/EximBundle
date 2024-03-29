<?php

namespace Evrinoma\EximBundle\Dto;

use Evrinoma\DtoBundle\Adaptor\EntityAdaptorInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\EximBundle\Entity\Server;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Storage\StorageInterface;
use Evrinoma\UtilsBundle\Storage\StorageTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServerDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class ServerDto extends AbstractDto implements EntityAdaptorInterface, StorageInterface, ActiveInterface
{
    use ActiveTrait;
    use StorageTrait;

//region SECTION: Fields
    private $ip;
    private $hostName;
    private $id;
//endregion Fields

//region SECTION: Protected
    /**
     * @return string
     */
    public function getClassEntity():string
    {
        return Server::class;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @param Server $entity
     *
     * @return mixed
     */
    public function fillEntity($entity):void
    {
        $entity
            ->setIp($this->getIp())
            ->setHostname($this->getHostName())
            ->setActive();
    }

    /**
     * @return bool
     */
    public function isValidHostName()
    {
        return (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->hostName) === 1);
    }

    /**
     * @return bool
     */
    public function isValidIp()
    {
        return (preg_match("/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $this->ip) === 1);
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto(Request $request):DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {

            $ip   = $request->get('ip');
            $name = $request->get('hostname');
            $id   = $request->get('id');

            if ($name) {
                $this->setHostName($name);
            }

            if ($ip) {
                $this->setIp($ip);
            }

            if ($id) {
                $this->setId($id);
            }
        }

       return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * @param mixed $id
     *
     * @return ServerDto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $ip
     *
     * @return ServerDto
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @param mixed $hostName
     *
     * @return ServerDto
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;

        return $this;
    }
//endregion Getters/Setters
}