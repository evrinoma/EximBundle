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
    /**
     * @var string
     */
    private $pattern;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasPattern(): bool
    {
        return $this->pattern !== null;
    }
//endregion Public

//region SECTION: Private
    /**
     * @param string $filterType
     *
     * @return RuleTypeDto
     */
    private function setFilterType(string $filterType): self
    {
        $this->filterType = $filterType;

        return $this;
    }

    /**
     * @param string $pattern
     *
     * @return RuleTypeDto
     */
    private function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);


        if ($class === $this->getClass()) {
            $filterType = $request->get('filterType');
            $pattern    = $request->get('pattern');
            if ($filterType) {
                $this->setFilterType($filterType);
            }
            if (!is_null($pattern)) {
                $this->setPattern($pattern);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getFilterType(): string
    {
        return $this->filterType;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
//endregion Getters/Setters
}