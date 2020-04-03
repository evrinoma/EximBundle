<?php

namespace Evrinoma\EximBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Evrinoma\EximBundle\Dto\AclDto;

/**
 * Class AclRepository
 *
 * @package Evrinoma\EximBundle\Repository
 */
class AclRepository extends EntityRepository
{
//region SECTION: Fields
    /**
     * @var AclDto
     */
    private $dto;
//endregion Fields

//region SECTION: Dto
    /**
     * @param AclDto $aclDto
     *
     * @return AclRepository
     */
    public function setDto($aclDto)
    {
        $this->dto = $aclDto;

        return $this;
    }
//endregion SECTION: Dto
//endregion Fields

//region SECTION: Find Filters Repository
    /**
     * @return mixed
     */
    public function findAcl()
    {
        $builder = $this->createQueryBuilder('acl');

        $builder
            ->leftJoin('acl.domain', 'domain')
            ->where("acl.active = 'a'");

        if ($this->dto && $this->dto->getId()) {
            $builder->andWhere('acl.id =  :id')
                ->setParameter('id', $this->dto->getId());
        } else {
            if ($this->dto && $this->dto->getDomain()->getDomainName()) {
                $builder->andWhere('domain.domain =  :domain')
                    ->setParameter('domain', $this->dto->getDomain()->getDomainName());
            }

            if ($this->dto && $this->dto->getEmail() && !$this->dto->getId()) {
                if ($this->dto->isEmail()) {
                    $builder->andWhere('acl.email LIKE :emailDomain or acl.email = :email')
                        ->setParameter('emailDomain', '*'.$this->dto->getEmailDomain().'%')
                        ->setParameter('email', $this->dto->getEmail());
                } else {
                    $builder->andWhere('acl.email LIKE :emailDomain')
                        ->setParameter('emailDomain', '%'.$this->dto->getEmailDomain().'%');
                }
            }
        }
        $builder->orderBy('acl.type', 'desc');

        return $builder->getQuery()->getResult();
    }
//endregion Find Filters Repository
}