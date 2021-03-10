<?php

namespace Evrinoma\EximBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use JMS\Serializer\Annotation\SerializedName;
/**
 * Class Spam
 *
 * @package App\Entity\Mail
 * @ORM\Table(name="mail_spam_rule")
 * @ORM\Entity(repositoryClass="Evrinoma\EximBundle\Repository\SpamRepository")
 */
class Spam implements ActiveInterface
{
    use IdTrait, ActiveTrait;

//region SECTION: Fields
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var Filter
     * @SerializedName("filter")
     * @ORM\ManyToOne(targetEntity="Filter", inversedBy="id", cascade={"all"})
     */
    private $type;

    /**
     * @var Conformity
     * @SerializedName("conformity")
     * @ORM\ManyToOne(targetEntity="Conformity", inversedBy="id", cascade={"all"})
     */
    private $conformity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain", type="string", length=512, nullable=true)
     */
    private $domain;

    /**
     * @var int
     *
     * @ORM\Column(name="hit", type="integer", nullable=false)
     */
    private $hit = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true, options={"default"="0000-00-00 00:00:00"})
     */
    private $updateAt;
//endregion Fields

//region SECTION: Getters/Setters
   /**
     * @return int
     */
    public function getSpamId(): int
    {
        return $this->getId();
    }

    /**
     * @return Filter
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Conformity
     */
    public function getConformity()
    {
        return $this->conformity;
    }

    /**
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @return int
     */
    public function getHit(): int
    {
        return $this->hit;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param Filter $type
     *
     * @return Spam
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param Conformity $conformity
     *
     * @return Spam
     */
    public function setConformity($conformity)
    {
        $this->conformity = $conformity;

        return $this;
    }

    /**
     * @param string|null $domain
     *
     * @return Spam
     */
    public function setDomain(?string $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @param int $hit
     *
     * @return Spam
     */
    public function setHit(int $hit)
    {
        $this->hit = $hit;

        return $this;
    }

    /**
     * @param \DateTime|null $updateAt
     *
     * @return Spam
     */
    public function setUpdateAt(?\DateTime $updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }
//endregion Getters/Setters
}