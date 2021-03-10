<?php

namespace Evrinoma\EximBundle\Dto;


use Evrinoma\DtoBundle\Adaptor\EntityAdaptorInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\EximBundle\Entity\Domain;
use Evrinoma\EximBundle\Vuetable\ResetVuetableInterface;
use Evrinoma\EximBundle\Vuetable\VuetableInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Storage\StorageInterface;
use Evrinoma\UtilsBundle\Storage\StorageTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DomainDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
final class DomainDto extends AbstractDto implements VuetableInterface, StorageInterface, EntityAdaptorInterface, ResetVuetableInterface, ActiveInterface
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
//endregion Protected

//region SECTION: Public
    /**
     * @param Domain $entity
     *
     * @return Domain
     */
    public function fillEntity($entity): void
    {
        $entity
            ->setDomain($this->getDomainName())
            ->setServer($this->getServerDto()->generatorEntity()->current())
            ->setActive();
    }

    /**
     * @return bool
     */
    public function isValidDomainName()
    {
        return $this->domainName && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->domainName) === 1);
    }

    public function resetPage(): ResetVuetableInterface
    {
        $this->setPage();

        return $this;
    }

    public function resetPerPage(): ResetVuetableInterface
    {
        $this->setPerPage();

        return $this;
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
            $id         = $request->get('id');

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
            $server = $request->get('server');
            if ($server) {
                $newRequest                      = $this->getCloneRequest();
                $server[DtoInterface::DTO_CLASS] = ServerDto::class;
                $newRequest->request->add($server);

                yield $newRequest;
            }
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
     * @return string
     */
    public function getClassEntity(): string
    {
        return Domain::class;
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
//endregion Getters/Setters
}