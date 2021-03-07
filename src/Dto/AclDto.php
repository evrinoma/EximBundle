<?php

namespace Evrinoma\EximBundle\Dto;


use Evrinoma\DtoBundle\Adaptor\EntityAdaptorInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\EximBundle\Entity\Acl;
use Evrinoma\EximBundle\Model\MailTrait;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Storage\StorageInterface;
use Evrinoma\UtilsBundle\Storage\StorageTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AclDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class AclDto extends AbstractDto implements StorageInterface, EntityAdaptorInterface
{
    use ActiveTrait;
    use MailTrait;
    use StorageTrait;

//region SECTION: Fields
    private $id;

    private $type;

    private $email;
    /**
     * @Dto(class="Evrinoma\EximBundle\Dto\DomainDto", generator="genRequestDomainDto")
     * @var DomainDto
     */
    private $domain;
//endregion Fields

//region SECTION: Protected
//endregion Protected

//region SECTION: Public
    /**
     * @param Acl $entity
     */
    public function fillEntity($entity): void
    {
        $entity
            ->setEmail($this->getEmail())
            ->setType($this->getType())
            ->setActive($this->getActive())
            ->setDomain($this->getDomain()->generatorEntity()->current());
    }

    /**
     * @return bool
     */
    public function isValidEmail()
    {
        return $this->email && (preg_match("/[a-zA-Z0-9_\-.+*]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $this->email) === 1);
    }
//endregion Public

//region SECTION: Private
    /**
     * @param mixed $email
     *
     * @return AclDto
     */
    private function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return AclDto
     */
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $type
     *
     * @return AclDto
     */
    private function setType($type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto($request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id      = $request->get('aclId');
            $active  = $request->get('active');
            $deleted = $request->get('is_deleted');
            $email   = $request->get('email');
            $type    = $request->get('type');

            if ($id) {
                $this->setId($id);
            }

            if ($active && $deleted) {
                $this->setActiveToDelete();
            }

            if ($email) {
                $this->setEmail($email);
            }

            if ($type) {
                $this->setType($type);
            }
        }

        return $this;
    }

    /**
     * @return \Generator
     */
    public function genRequestDomainDto(?Request $request): ?\Generator
    {
        if ($request) {
            $clone = clone $request;

            if ($request->attributes->has(DtoInterface::DTO_CLASS)) {
                $clone->attributes->add([DtoInterface::DTO_CLASS => DomainDto::class]);
            }
            if ($request->query->has(DtoInterface::DTO_CLASS)) {
                $clone->query->add([DtoInterface::DTO_CLASS => DomainDto::class]);
            }
            if ($request->request->has(DtoInterface::DTO_CLASS)) {
                $clone->request->add([DtoInterface::DTO_CLASS => DomainDto::class]);
            }

            yield $clone;
        }
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getClassEntity(): string
    {
        return Acl::class;
    }

    /**
     * @return DomainDto
     */
    public function getDomain(): DomainDto
    {
        return $this->domain;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getEmailDomain()
    {
        return mb_strcut($this->email, mb_strpos($this->email, '@'), mb_strlen($this->email));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param DomainDto $domain
     *
     * @return AclDto
     */
    public function setDomain(DomainDto $domain)
    {
        $this->domain = $domain;

        return $this;
    }
//endregion Getters/Setters
}