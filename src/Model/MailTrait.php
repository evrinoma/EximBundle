<?php

namespace Evrinoma\EximBundle\Model;

/**
 * Trait MailTrait
 *
 * @package Evrinoma\EximBundle\Model
 */
trait MailTrait
{
    abstract public function getEmail(): string;

    /**
     * @return mixed
     */
    public function isEmail()
    {
        return mb_strpos($this->getEmail(), '*@') === false;
    }
}