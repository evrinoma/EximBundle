<?php

namespace Evrinoma\EximBundle\Dto;


use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Storage\StorageInterface;
use Evrinoma\UtilsBundle\Storage\StorageTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConformityDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class ConformityDto extends AbstractDto implements StorageInterface
{
    use StorageTrait;
//region SECTION: Fields
    /**
     * @var string
     */
    private $type;
//endregion Fields

//region SECTION: Private
    /**
     * @param string $type
     *
     * @return ConformityDto
     */
    private function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto($request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $type = $request->get('conformityType');
            $this->setType($type);
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
//endregion Getters/Setters
}