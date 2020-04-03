<?php

namespace Evrinoma\EximBundle\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\EximBundle\Dto\DomainDto;
use Evrinoma\EximBundle\Entity\Domain;
use Evrinoma\EximBundle\Repository\DomainRepository;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

/**
 * Class DomainManager
 *
 * @package Evrinoma\EximBundle\Manager
 * @property DomainRepository $repository
 */
final class DomainManager extends AbstractEntityManager implements DomainManagerInterface
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Domain::class;

    private $serverManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * DomainManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ServerManagerInterface $serverManager
     */
    public function __construct(EntityManagerInterface $entityManager, ServerManagerInterface $serverManager)
    {
        parent::__construct($entityManager);

        $this->serverManager = $serverManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param DomainDto $domainDto
     *
     * @return Domain
     * @throws \Exception
     */
    public function toSave(DomainDto $domainDto)
    {
        $entity = null;

        if ($domainDto->isValidDomainName() && $domainDto->getServer()->isValidHostName()) {
            $criteria = $this->getCriteria();
            if ($domainDto->getId()) {
                $criteria->andWhere($criteria->expr()->eq('id', $domainDto->getId()));
            } else {
                $criteria->andWhere(
                    $criteria->expr()->eq('domain', $domainDto->getDomainName())
                );
            }
            $existDomain = $this->repository->matching($criteria);
            if ($domainDto->getServer()->getEntitys() === null) {
                $domainDto->getServer()->setEntitys($this->serverManager->get($domainDto->getServer())->getData());
            }
            $entity = $this->save($domainDto, $existDomain->count() ? $existDomain->first() : new Domain());
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $entity;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param DomainDto $domainDto
     *
     * @return $this
     */
    public function get(?DomainDto $domainDto)
    {
        if ($domainDto) {
            $this->setData($this->repository->setDto($domainDto)->findDomain());
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }


    /**
     * если фильтр задан то возвращаем число всех найденных записей
     *
     * @param DomainDto|null $domainDto
     *
     * @return int
     */
    public function getCount($domainDto = null)
    {
        $count = 0;
        if ($domainDto) {
            $dtoClone = clone $domainDto;
            $dtoClone->setPerPage()->setPage();
            $count = $domainDto ? count($this->repository->setDto($dtoClone)->findDomain()) : 0;
        }

        return $count;
    }

    /**
     * @return int
     */
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}