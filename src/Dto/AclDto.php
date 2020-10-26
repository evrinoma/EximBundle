<?php

namespace Evrinoma\EximBundle\Dto;


use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\EximBundle\Entity\Acl;
use Evrinoma\EximBundle\Model\MailTrait;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AclDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class AclDto extends AbstractDto
{
    use ActiveTrait;
    use MailTrait;

//region SECTION: Fields
    private $id;

    private $type;

    private $email;

    /**
     * @Dto(class="Evrinoma\EximBundle\Dto\DomainDto")
     * @var DomainDto
     */
    private $domain;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity()
    {
        return Acl::class;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @return bool
     */
    public function isValidEmail()
    {
        return $this->email && (preg_match("/[a-zA-Z0-9_\-.+*]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $this->email) === 1);
    }

    /**
     * @param Acl $entity
     *
     * @return Acl
     */
    public function fillEntity($entity)
    {
        $entity
            ->setEmail($this->getEmail())
            ->setType($this->getType())
            ->setActive($this->getActive())
            ->setDomain($this->getDomain()->generatorEntity()->current());

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function lookingForRequest()
    {
        return DtoInterface::DEFAULT_LOOKING_REQUEST;
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
            $id      = $request->get('id');
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
//endregion SECTION: Dto

//region SECTION: Getters/Setters
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

    /**
     * @param mixed $email
     *
     * @return AclDto
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return AclDto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $type
     *
     * @return AclDto
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters
}