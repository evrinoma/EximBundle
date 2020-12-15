<?php

namespace Evrinoma\EximBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Evrinoma\EximBundle\Model\AclModel;
use Evrinoma\EximBundle\Model\ClassEntityTrait;
use Evrinoma\EximBundle\Model\MailTrait;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Acl
 *
 * @package Evrinoma\EximBundle\Entity
 * @ORM\Table(name="mail_acl")
 * @ORM\Entity(repositoryClass="Evrinoma\EximBundle\Repository\AclRepository")
 */
class Acl
{
    use ClassEntityTrait, ActiveTrait, MailTrait;

//region SECTION: Fields
    /**
     * @var int
     * @Exclude
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type = AclModel::WHITE;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var Domain
     * @Type("Evrinoma\EximBundle\Entity\Domain")
     * @ORM\ManyToOne(targetEntity="Evrinoma\EximBundle\Entity\Domain", inversedBy="id")
     */
    private $domain;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isWhite()
    {
        return $this->type === AclModel::WHITE;
    }

    /**
     * @return bool
     */
    public function isBlack()
    {
        return $this->type === AclModel::BLACK;
    }

//endregion Public

//region SECTION: Getters/Setters
    /**
     * @VirtualProperty
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Domain
     */
    public function getDomain(): Domain
    {
        return $this->domain;
    }

    /**
     * @param string $type
     *
     * @return Acl
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return Acl
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param Domain $domain
     *
     * @return Acl
     */
    public function setDomain(Domain $domain)
    {
        $this->domain = $domain;

        return $this;
    }
//endregion Getters/Setters

}
