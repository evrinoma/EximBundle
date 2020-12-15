<?php

namespace Evrinoma\EximBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Evrinoma\EximBundle\Model\ClassEntityTrait;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class Conformity
 *
 * @package Evrinoma\EximBundle\Entity
 * @ORM\Table(name="mail_conformity")
 * @ORM\Entity()
 */
class Conformity
{
    use IdTrait, ClassEntityTrait, ActiveTrait;

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
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
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
     * @param string|null $type
     *
     * @return $this
     */
    public function setType(?string $type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters
}