<?php

namespace Evrinoma\EximBundle\Dto;


use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Storage\StorageInterface;
use Evrinoma\UtilsBundle\Storage\StorageTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RuleTypeDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class RuleTypeDto extends AbstractDto implements StorageInterface
{
    use StorageTrait;
//region SECTION: Fields
    /**
     * @var string
     */
    private $filterType;
//endregion Fields

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto($request):DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        $filterType = $request->get('filterType');
        if ($filterType) {
            $this->setFilterType($filterType);
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getFilterType()
    {
        return $this->filterType;
    }

    /**
     * @param mixed $filterType
     *
     * @return RuleTypeDto
     */
    private function setFilterType($filterType)
    {
        $this->filterType = $filterType;

        return $this;
    }
//endregion Getters/Setters
}