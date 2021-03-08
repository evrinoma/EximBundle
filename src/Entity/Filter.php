<?php
namespace Evrinoma\EximBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use JMS\Serializer\Annotation\SerializedName;
/**
 * Class Spam
 *
 * @package Evrinoma\EximBundle\Entity\Mail
 * @ORM\Table(name="mail_filter")
 * @ORM\Entity()
 */
class Filter
{
    use IdTrait, ActiveTrait;

    public const FILTER_BURN = 'burn';
    public const FILTER_IP = 'ip';
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
     * @SerializedName("filterType")
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;


    /**
     * @var string
     *
     * @ORM\Column(name="pattern", type="string")
     */
    private $pattern = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isPatternBurn(): bool
    {
        return $this->pattern === self::FILTER_BURN;
    }

    /**
     * @return bool
     */
    public function isPatternIP(): bool
    {
        return $this->pattern === self::FILTER_IP;
    }

    /**
     * @return bool
     */
    public function isPattern(): bool
    {
        return $this->pattern === '';
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $pattern
     *
     * @return Filter
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @param string|null $type
     *
     * @return Filter
     */
    public function setType(?string $type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters


}