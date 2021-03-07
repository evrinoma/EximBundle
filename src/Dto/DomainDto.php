<?php

namespace Evrinoma\EximBundle\Dto;


use Evrinoma\DtoBundle\Adaptor\EntityAdaptorInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\EximBundle\Entity\Domain;
use Evrinoma\UtilsBundle\Storage\StorageInterface;
use Evrinoma\UtilsBundle\Storage\StorageTrait;
use Evrinoma\EximBundle\Vuetable\VuetableInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DomainDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class DomainDto extends AbstractDto implements VuetableInterface, StorageInterface, EntityAdaptorInterface
{
    use ActiveTrait;
    use StorageTrait;

//region SECTION: Fields
    private $id;
    private $domainName;
    private $page;
    private $perPage;
    private $filter;

    /**
     * @Dto(class="Evrinoma\EximBundle\Dto\ServerDto", generator="genRequestServerDto")
     * @var ServerDto
     */
    private $serverDto;
//endregion Fields

//region SECTION: Protected
    /**
     * @return string
     */
    public function getClassEntity(): string
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
    public function fillEntity($entity):void
    {
        $entity
            ->setDomain($this->getDomainName())
            ->setServer($this->getServer()->generatorEntity()->current())
            ->setActive();
    }

    /**
     * @return bool
     */
    public function isValidDomainName()
    {
        return $this->domainName && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->domainName) === 1);
    }
//endregion Public

//region SECTION: Private
    /**
     * @param mixed $page
     *
     * @return DomainDto
     */
    private function setPage($page = null)
    {
        $this->page = (int)$page;

        return $this;
    }

    /**
     * @param mixed $perPage
     *
     * @return DomainDto
     */
    private function setPerPage($perPage = null)
    {
        $this->perPage = (int)$perPage;

        return $this;
    }

    /**
     * @param mixed $filter
     *
     * @return DomainDto
     */
    private function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param mixed $domainName
     *
     * @return DomainDto
     */
    private function setDomainName($domainName = null)
    {
        $this->domainName = $domainName;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return DomainDto
     */
    private function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param ServerDto $serverDto
     *
     * @return DomainDto
     */
    public function setServerDto(ServerDto $serverDto): self
    {
        $this->serverDto = $serverDto;

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto($request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {

            $page       = $request->get('page');
            $perPage    = $request->get('per_page');
            $filter     = $request->get('filter');
            $domainName = $request->get('domain');
            $id         = $request->get('domainId');

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

    /**
     * @return \Generator
     */
    public function genRequestServerDto(?Request $request): ?\Generator
    {
        if ($request) {
            $clone = clone $request;

            if ($request->attributes->has(DtoInterface::DTO_CLASS)) {
                $clone->attributes->add([DtoInterface::DTO_CLASS => ServerDto::class]);
            }
            if ($request->query->has(DtoInterface::DTO_CLASS)) {
                $clone->query->add([DtoInterface::DTO_CLASS => ServerDto::class]);
            }
            if ($request->request->has(DtoInterface::DTO_CLASS)) {
                $clone->request->add([DtoInterface::DTO_CLASS => ServerDto::class]);
            }

            yield $clone;
        }
    }

    /**
     * @return ServerDto
     */
    public function getServerDto()
    {
        return $this->serverDto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
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
     * @param mixed $hostNameServer
     *
     * @return DomainDto
     */
    public function setHostNameServer($hostNameServer = null)
    {
        $this->hostNameServer = $hostNameServer;

        return $this;
    }
//endregion Getters/Setters
}