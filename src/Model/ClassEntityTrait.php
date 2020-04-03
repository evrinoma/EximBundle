<?php

namespace Evrinoma\EximBundle\Model;

use Doctrine\Common\Util\ClassUtils;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Trait ClassEntityTrait
 *
 * @package Evrinoma\EximBundle\Model
 */
trait ClassEntityTrait
{
//region SECTION: Getters/Setters
    /**
     * @VirtualProperty()
     * @return string
     */
    public function getClass()
    {
        return ClassUtils::getRealClass(static::class);
    }
//endregion Getters/Setters
}