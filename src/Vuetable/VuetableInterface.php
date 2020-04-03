<?php

namespace Evrinoma\EximBundle\Vuetable;

/**
 * Interface VuetableInterface
 *
 * @package Evrinoma\EximBundle\Vuetable
 */
interface VuetableInterface
{
    /**
     * @return mixed
     */
    public function getPage();

    /**
     * @return mixed
     */
    public function getPerPage();

    /**
     * @return mixed
     */
    public function getFilter();
}