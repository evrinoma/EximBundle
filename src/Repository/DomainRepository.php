<?php

namespace Evrinoma\EximBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Evrinoma\EximBundle\Dto\DomainDto;

/**
 * Class DomainRepository
 *
 * @package Evrinoma\EximBundle\Repository
 */
class DomainRepository extends EntityRepository
{
//region SECTION: Fields
    /**
     * @var DomainDto
     */
    private $dto;
//endregion Fields

//region SECTION: Dto
    /**
     * @param DomainDto $dto
     *
     * @return DomainRepository
     */
    public function setDto(DomainDto $dto)
    {
        $this->dto = $dto;

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Find Filters Repository
    public function findDomain()
    {
        $builder = $this->createQueryBuilder('domain');

        $builder
            ->leftJoin('domain.server', 'server')
            ->where("domain.active = 'a'")
            ->andWhere("server.active = 'a'");
        if ($this->dto && $this->dto->getId()) {
            $builder->andWhere('domain.id = :domainId')
                ->setParameter('domainId', $this->dto->getId());
        }
        if ($this->dto && $this->dto->getFilter()) {
            $builder->andWhere('domain.domain like :filter or server.hostname like :filter')
                ->setParameter('filter', '%'.$this->dto->getFilter().'%');
        }
        if ($this->dto && $this->dto->getDomainName()) {
            $builder->andWhere('domain.domain = :filter')
                ->setParameter('filter', $this->dto->getDomainName());
        }
        if ($this->dto && $this->dto->getServerDto() && $this->dto->getServerDto()->getHostName()) {
            $builder->andWhere('server.hostname like :hostNameServer')
                ->setParameter('hostNameServer', $this->dto->getServerDto()->getHostName());
        }
        if ($this->dto && $this->dto->getPerPage()) {
            $builder->setMaxResults($this->dto->getPerPage());
        }
        if ($this->dto && $this->dto->getPage() && $this->dto->getPerPage()) {
            $builder->setFirstResult($this->dto->getPage() * $this->dto->getPerPage() - $this->dto->getPerPage());
        }

        return $builder->getQuery()->getResult();
    }
//endregion Find Filters Repository
}