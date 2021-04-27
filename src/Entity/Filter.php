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
 * @package Evrinoma\EximBundle\Entity\Mail
 * @ORM\Table(name="mail_filter")
 * @ORM\Entity()
 */
class Filter implements ActiveInterface
{
    use IdTrait, ActiveTrait;

//region SECTION: Fields
    public const PATTERN_BURN  = 'burn';
    public const PATTERN_IP    = 'ip';
    public const PATTERN_EMPTY = '';
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
    private $pattern = self::PATTERN_EMPTY;
//endregion Fields

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