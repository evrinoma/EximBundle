<?php

namespace Evrinoma\EximBundle\Dto;

use Evrinoma\DtoBundle\Annotation\Dtos;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\SettingsBundle\Dto\SettingsDto;
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
    private $searchString;
    /**
     * @Dtos(class="Evrinoma\SettingsBundle\Dto\SettingsDto", generator="genRequestSettingsDto", add="addSettingsDto")
     * @var SettingsDto []
     */
    private $searchFiles = [];
//endregion Fields

//region SECTION: Public
    /**
     * @return int
     */
    public function isValidSearchStr()
    {
        return $this->searchString !== '';
    }

    public function hasFile($fileName)
    {
        return (count($this->searchFiles) === 0 || array_key_exists($fileName, $this->searchFiles));
    }
//endregion Public

//region SECTION: Private
    /**
     * @param string $searchString
     *
     * @return LogSearchDto
     */
    private function setSearchString(string $searchString): self
    {
        $this->searchString = $searchString;

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
        $searchString = $request->get('searchString');

        if ($searchString) {
            $this->setSearchString($searchString);
        }

        return $this;
    }

    /**
     * @param SettingsDto $dto
     *
     * @return $this
     */
    public function addSettingsDto(SettingsDto $dto): self
    {
        $name = $dto->getFile();

        if ($name) {
            $this->searchFiles[$name] = $dto;
        } else {
            $this->searchFiles[] = $dto;
        }

        return $this;
    }

    /**
     * @return \Generator
     */
    public function genRequestSettingsDto(?Request $request): ?\Generator
    {
        if ($request) {
            $searchFiles = $request->get('searchFiles');
            if ($searchFiles) {
                foreach ($searchFiles as $searchFile) {
                    $request = new Request();
                    if (is_array($searchFile)) {
                        $params = $searchFile;
                    } else {
                        $params['file'] = $searchFile;
                    }
                    $params[DtoInterface::DTO_CLASS] = SettingsDto::class;
                    $request->request->add($params);

                    yield $request;
                }
            }
        }
    }

    /**
     * @return SettingsDto[]
     */
    public function getSettingsDto(): array
    {
        return $this->searchFiles;
    }

    /**
     * @return mixed
     */
    public function getSearchString()
    {
        return $this->searchString;
    }
//endregion SECTION: Dto


}