<?php

namespace Evrinoma\EximBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Evrinoma\EximBundle\Dto\SpamDto;


/**
 * Class SpamRepository
 *
 * @package Evrinoma\EximBundle\Repository
 */
class SpamRepository extends EntityRepository
{

    //region SECTION: Fields
    /**
     * @var SpamDto
     */
    private $dto;
//endregion Fields

//region SECTION: Dto
    /**
     * @param SpamDto $spamDto
     *
     * @return SpamRepository
     */
    public function setDto($spamDto)
    {
        $this->dto = $spamDto;

        return $this;
    }

//endregion SECTION: Dto

//region SECTION: Find Filters Repository
    public function findSpam()
    {

        $builder = $this->createQueryBuilder('spam');

        $builder->where("spam.active = 'a'");

        if ($this->dto && $this->dto->getId()) {
            $builder->andWhere('spam.id =  :id')
                ->setParameter('id', $this->dto->getId());
        } else {
            if ($this->dto && $this->dto->getRuleType() && $this->dto->getRuleType()->getType()) {
                $builder->leftJoin('spam.type', 'filterType')
                    ->andWhere('filterType.type = :filter')
                    ->setParameter('filter', $this->dto->getRuleType()->getType());
            }

            if ($this->dto && $this->dto->isConformity() && $this->dto->getConformity() && $this->dto->getConformity()->getType()) {
                $builder->leftJoin('spam.conformity', 'conformityType')
                    ->andWhere('conformityType.type = :conformity')
                    ->setParameter('conformity', $this->dto->getConformity()->getType());
            }

            if ($this->dto && $this->dto->getSpamRecord()) {
                $builder->andWhere('spam.domain like :spamRecordLike or spam.domain = :spamRecord')
                    ->setParameter('spamRecordLike', '%'.$this->dto->getSpamRecord())
                    ->setParameter('spamRecord', $this->dto->getSpamRecord());
            }
        }

        return $builder->getQuery()->getResult();
    }
//endregion Find Filters Repository
}