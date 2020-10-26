<?php

namespace Evrinoma\EximBundle\Dto;



use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\EximBundle\Entity\Domain;
use Evrinoma\EximBundle\Vuetable\VuetableInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DomainDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class DomainDto extends AbstractDto implements VuetableInterface
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;
    private $domainName;
    private $page;
    private $perPage;
    private $filter;

    /**
     * @Dto(class="Evrinoma\EximBundle\Dto\ServerDto")
     * @var ServerDto
     */
    private $server;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity()
    {
        return Domain::class;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @param Domain $entity
     *
     * @return Domain
     */
    public function fillEntity($entity)
    {
        $entity->setDomain($this->getDomainName())->setServer($this->getServer()->generatorEntity()->current())->setActive();

        return $entity;
    }

    /**
     * @return bool
     */
    public function isValidDomainName()
    {
        return $this->domainName && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->domainName) === 1);
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto($request)
    {
        $class = $request->get('class');

        if ($class === $this->getClassEntity()) {

            $page           = $request->get('page');
            $perPage        = $request->get('per_page');
            $filter         = $request->get('filter');
            $domainName     = $request->get('domain');
            $id             = $request->get('id');

            if ($id !== null) {
                $this->setId($id);
            }
            if ($domainName !== null) {
                $this->setDomainName($domainName);
            }
            if ($page !== null) {
                $this->setPage($page);
            }
            if ($perPage !== null) {
                $this->setPerPage($perPage);
            }
            if ($filter !== null) {
                $this->setFilter($filter);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return ServerDto
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @inheritDoc
     */
    public function lookingForRequest()
    {
        return 'domain';
    }

    /**
     * @return mixed
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param FactoryDtoInterface $server
     *
     * @return DomainDto
     */
    public function setServer($server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @param mixed $page
     *
     * @return DomainDto
     */
    public function setPage($page = null)
    {
        $this->page = (int)$page;

        return $this;
    }

    /**
     * @param mixed $perPage
     *
     * @return DomainDto
     */
    public function setPerPage($perPage = null)
    {
        $this->perPage = (int)$perPage;

        return $this;
    }

    /**
     * @param mixed $filter
     *
     * @return DomainDto
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param mixed $hostNameServer
     *
     * @return DomainDto
     */
    public function setHostNameServer($hostNameServer = null)
    {
        $this->hostNameServer = $hostNameServer;

        return $this;
    }

    /**
     * @param mixed $domainName
     *
     * @return DomainDto
     */
    public function setDomainName($domainName = null)
    {
        $this->domainName = $domainName;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return DomainDto
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }
//endregion Getters/Setters
}