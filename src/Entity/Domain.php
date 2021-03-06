<?php

namespace Evrinoma\EximBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\EximBundle\Dto\DomainDto;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Domains
 *
 * @ORM\Table(name="mail_domain")
 * @ORM\Entity(repositoryClass="Evrinoma\EximBundle\Repository\DomainRepository")
 */
class Domain implements ActiveInterface
{
    use ActiveTrait;

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
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain = '';
    /**
     * @var Server
     * @Type("Evrinoma\EximBundle\Entity\Server")
     * @ORM\ManyToOne(targetEntity="Evrinoma\EximBundle\Entity\Server", inversedBy="id", cascade={"all"})
     */
    private $server;
//endregion Fields

//region SECTION: Public
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @VirtualProperty()
     * @return string
     */
    public function getClass()
    {
        return DomainDto::class;
    }

    /**
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getIpServer(): string
    {
        return $this->server->getIp();
    }

    /**
     * @return string|null
     */
    public function getHostNameServer(): ?string
    {
        return $this->server->getHostname();
    }

    /**
     * @param $server
     *
     * @return $this
     */
    public function setServer($server)
    {
        if ($server) {
            $this->server = $server;
        }

        return $this;
    }

    /**
     * @param string $domain
     *
     * @return Domain
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @param string $relayAdr
     *
     * @return Domain
     */
    public function setRelayAdr(string $relayAdr)
    {
        $this->server->setIp($relayAdr);

        return $this;
    }

    /**
     * @param string|null $mx
     *
     * @return Domain
     */
    public function setMx(?string $mx)
    {
        $this->server->setHostname($mx);

        return $this;
    }
//endregion Getters/Setters
}
