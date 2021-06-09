<?php

namespace Evrinoma\EximBundle\Manager;


use Doctrine\ORM\QueryBuilder;
use Evrinoma\EximBundle\Dto\SpamDto;
use Evrinoma\EximBundle\Entity\Conformity;
use Evrinoma\EximBundle\Entity\Filter;
use Evrinoma\EximBundle\Entity\Spam;
use Evrinoma\EximBundle\Repository\SpamRepository;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

/**
 * Class SpamManager
 *
 * @package Evrinoma\EximBundle\Manager
 * @property SpamRepository $repository
 */
final class SpamManager extends AbstractEntityManager implements SpamManagerInterface
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Spam::class;
//endregion Fields

//region SECTION: Public
    /**
     * @param SpamDto $spamDto
     *
     * @return string|null
     */
    public function toSave(SpamDto $spamDto)
    {
        if ($spamDto->isValid()) {
            $spamDto->getRuleType()->setEntities($this->getType($spamDto)->getData());
            $spamDto->getConformity()->setEntities($this->getConformity($spamDto)->getData());
            $entity = $this->repository->setDto($spamDto)->findSpam();
            $spamDto->setEntities($entity);
            if (!$spamDto->getId() && count($entity)) {
                $this->setRestBadRequest();
                $entity = 'уже существует';
            } else {
                $entity = $this->save($spamDto, count($entity) ? reset($entity) : new Spam());
            }
        } else {
            $this->setRestBadRequest();
            $entity = 'нет входных данных';
        }

        return $entity;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param SpamDto $spamDto
     *
     * @return $this|SpamManagerInterface
     */
    public function get(?SpamDto $spamDto): SpamManagerInterface
    {
        if ($spamDto) {
            $this->setData($this->repository->setDto($spamDto)->findSpam());
        } else {
            $this->setRestBadRequest();
        }

        return $this;
    }

    /**
     * @param SpamDto $spamDto
     *
     * @return $this
     */
    public function getType(SpamDto $spamDto): SpamManagerInterface
    {
        /** @var QueryBuilder $builder */
        $builder = $this->entityManager->getRepository(Filter::class)->createQueryBuilder('filterType');

        $builder->where("filterType.active = 'a'");

        if ($spamDto->getRuleType() && $spamDto->getRuleType()->getFilterType()) {
            $builder
                ->andWhere('filterType.type = :filterType')
                ->setParameter('filterType', $spamDto->getRuleType()->getFilterType());
        }

        $this->setData($builder->getQuery()->getResult());

        return $this;
    }

    /**
     * @param SpamDto $spamDto
     *
     * @return $this
     */
    public function getConformity(SpamDto $spamDto): SpamManagerInterface
    {
        /** @var QueryBuilder $builder */
        $builder = $this->entityManager->getRepository(Conformity::class)->createQueryBuilder('conformity');

        $builder->where("conformity.active = 'a'");

        if ($spamDto->getConformity() && $spamDto->getConformity()->getType()) {
            $builder
                ->andWhere('conformity.type = :conformity')
                ->setParameter('conformity', $spamDto->getConformity()->getType());
        }

        $this->setClassModel(Conformity::class)->setData($builder->getQuery()->getResult());

        return $this;
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