<?php

namespace Evrinoma\EximBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LogSearchDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class LogSearchDto extends AbstractDto
{
    use ActiveTrait;

//region SECTION: Fields
    private   $searchString;
    private   $searchFile = [];
//endregion Fields

//region SECTION: Public
    /**
     * @param Object $entity
     *
     * @return mixed
     */
    public function fillEntity($entity)
    {
        $entity->setActive();

        return $entity;
    }

    /**
     * DtoAdapter(adaptors={
     *     DtoAdapterItem(class="Evrinoma\SettingsBundle\Dto\SettingsDto",method="setClassSettingsEntity")
     * })
     */
    public function getClass():string
    {
        return parent::getClass();
    }

    /**
     * @return int
     */
    public function isValidSearchStr()
    {
        return $this->searchString !== '';
    }

    public function hasFile($fileName)
    {
        return (count($this->searchFile) === 0 || array_key_exists($fileName, $this->searchFile));
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto($request):DtoInterface
    {
        $searchString = $request->get('searchString');
        $searchFile   = $request->get('searchFile');

        if ($searchString) {
            $this->setSearchString($searchString);
        }

        if ($searchFile) {
            $this->setSearchFile($searchFile);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getClassEntity():?string
    {
        return static::class;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * @return mixed
     */
    public function getSearchFile()
    {
        return $this->searchFile;
    }

    /**
     * @param mixed $searchString
     *
     * @return LogSearchDto
     */
    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;

        return $this;
    }

    /**
     * @param mixed $searchFile
     *
     * @return LogSearchDto
     */
    public function setSearchFile($searchFile)
    {
        $this->searchFile = array_flip(preg_split('/,/', $searchFile, null, PREG_SPLIT_NO_EMPTY));

        return $this;
    }
//endregion Getters/Setters
}