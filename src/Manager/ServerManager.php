<?php

namespace Evrinoma\EximBundle\Manager;

use Evrinoma\EximBundle\Dto\ServerDto;
use Evrinoma\EximBundle\Entity\Server;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

/**
 * Class ServerManager
 *
 * @package Evrinoma\EximBundle\Manager
 */
final class ServerManager extends AbstractEntityManager implements ServerManagerInterface
{

    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Server::class;
//endregion Fields

//region SECTION: Public
    /**
     * @param ServerDto $serverDto
     *
     * @return Server|array|null
     */
    public function toSave(ServerDto $serverDto)
    {
        $entity = null;

        if ($serverDto->isValidHostName() && $serverDto->isValidIp()) {
            $criteria = $this->getCriteria();
            if ($serverDto->getId()) {
                $criteria->andWhere(
                    $criteria->expr()->orX(
                        $criteria->expr()->eq('hostname', $serverDto->getHostName()),
                        $criteria->expr()->eq('id', $serverDto->getId())
                    )
                );
            } else {
                $criteria->andWhere($criteria->expr()->eq('hostname', $serverDto->getHostName()));
                if ($serverDto->getHostName()) {
                    $criteria->andWhere($criteria->expr()->eq('ip', $serverDto->getIp()));
                }
            }
            $existServer = $this->repository->matching($criteria);
            if (!$serverDto->getId() && $existServer->count() >= 1) {
                $this->setRestServerErrorUnknownError();
            } else {
                if ($existServer->count() > 1) {
                    $this->setRestServerErrorUnknownError();
                } else {
                    $entity = $this->save($serverDto, $existServer->count() ? $existServer->first() : new Server());
                }
            }
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $entity;
    }
//endregion Public


//region SECTION: Getters/Setters
    /**
     * @param ServerDto $serverDto
     *
     * @return $this
     * @throws \Exception
     */
    public function get(?ServerDto $serverDto): ServerManagerInterface
    {
        if ($serverDto) {
            $criteria = $this->getCriteria();
            if ($serverDto->getId()) {
                $criteria->andWhere($criteria->expr()->eq('id', $serverDto->getId()));
            }
            if ($serverDto->getIp()) {
                $criteria->andWhere(
                    $criteria->expr()->eq('ip', $serverDto->getIp())
                );
            }
            if ($serverDto->getHostName()) {
                $criteria->andWhere(
                    $criteria->expr()->eq('hostname', $serverDto->getHostName())
                );
            }
            $value = $this->repository->matching($criteria);

            $this->setData($value->count() ? $value->toArray() : null);
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}