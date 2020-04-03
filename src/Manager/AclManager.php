<?php

namespace Evrinoma\EximBundle\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\EximBundle\Dto\AclDto;
use Evrinoma\EximBundle\Entity\Acl;
use Evrinoma\EximBundle\Model\AclModel;
use Evrinoma\EximBundle\Repository\AclRepository;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

/**
 * Class AclManager
 *
 * @package Evrinoma\EximBundle\Manager
 * @property AclRepository $repository
 */
class AclManager extends AbstractEntityManager implements AclManagerInterface
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Acl::class;

    private $domainManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * AclManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param DomainManagerInterface $domainManager
     */
    public function __construct(EntityManagerInterface $entityManager, DomainManagerInterface $domainManager)
    {
        parent::__construct($entityManager);

        $this->domainManager = $domainManager;
    }
//endregion Constructor


//region SECTION: Public

    /**
     * @param AbstractDto $aclDto
     *
     * @param             $entity
     * @param             $temp
     *
     * @return Acl
     * @throws \Exception
     */
    public function toSave(AclDto $aclDto)
    {
        if ($aclDto->isValidEmail()) {
            $entity = $this->repository->setDto($aclDto)->findAcl();
            $aclDto->setEntitys($entity);

            $recordExist = false;
            if (!$aclDto->getId() && $aclDto->isEmail() && count($entity)) {
                if (count($entity) === 1) {
                    $item = current($entity);
                    if (!$item->isEmail() && $item->isBlack()) {
                        $recordExist = false;
                    } else {
                        $recordExist = true;
                    }
                } else {
                    $recordExist = true;
                }
            }

            if ($recordExist) {
                $this->setRestClientErrorBadRequest();
                $entity = 'уже существует';
            } else {
                $aclDto->getDomain()->setEntitys($this->domainManager->get($aclDto->getDomain())->getData());
                if ($aclDto->getDomain()->hasSingleEntity()) {
                    $entity = $this->save($aclDto, count($entity) ? reset($entity) : new Acl());
                } else {
                    $this->setRestClientErrorBadRequest();
                    $entity = 'нет домена или их несколько';
                }
            }
        } else {
            $this->setRestClientErrorBadRequest();
            $entity = 'нет входных данных';
        }

        return $entity;
    }
//endregion Public

//region SECTION: Getters/Setters

    /**
     * @param $aclDto
     *
     * @return AclManagerInterface
     */
    public function get(?AclDto $aclDto): AclManagerInterface
    {
        if ($aclDto) {
            $this->setData($this->repository->setDto($aclDto)->findAcl());
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }

    /**
     * @return AclManagerInterface
     */
    public function getModel(): AclManagerInterface
    {
        $this->setClassModel(AclModel::class)->setData([AclModel::WHITE, AclModel::BLACK]);

        return $this;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}