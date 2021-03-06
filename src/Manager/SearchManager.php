<?php

namespace Evrinoma\EximBundle\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\EximBundle\Dto\ApartDto\FileDto;
use Evrinoma\EximBundle\Dto\LogSearchDto;
use Evrinoma\SettingsBundle\Manager\SettingsManagerInterface;
use Evrinoma\ShellBundle\Core\ShellInterface;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

/**
 * Class SearchManager
 *
 * @package Evrinoma\EximBundle\Manager
 */
final class SearchManager extends AbstractEntityManager implements SearchManagerInterface
{
    use RestTrait;

//region SECTION: Fields

    /**
     * @var \Evrinoma\SettingsBundle\Entity\Settings[]
     */
    private $settings = [];
    private $searchResult = [];

    /**
     * @var LogSearchDto
     */
    private $dto;

    private $step = 5;

    private $settingsManager;

    /**
     * @var ShellInterface
     */
    private $shellManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * SearchManager constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param ShellInterface           $shellManager
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(EntityManagerInterface $entityManager, ShellInterface $shellManager, SettingsManagerInterface $settingsManager)
    {
        parent::__construct($entityManager);

        $this->settingsManager = $settingsManager;

        $this->shellManager = $shellManager;
    }
//endregion Constructor

//region SECTION: Public

    public function saveSettings()
    {
        return $this->settingsManager->saveCollection($this->dto, $this->getSettings());
    }
//endregion Public

//region SECTION: Private
    /**
     * @return $this
     */
    private function loadSettings()
    {
        $this->settings = $this->settingsManager->toSettings($this->dto);

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    private function getNumberLineMeet()
    {
        foreach ($this->settings as $setting) {
            $fileDto = $setting->getData();
            if ($fileDto instanceof FileDto) {
                if ($this->dto->hasFile($fileDto->getName())) {
                    $file = $fileDto->getFilePath();
                    $run  = $this->shellManager->getProgram('cat').' '.escapeshellarg($file).' | '.
                        $this->shellManager->getProgram('grep').' -ni '.escapeshellarg($this->dto->getSearchString()).' | '.
                        $this->shellManager->getProgram('sed').' -n \'s/^\\([0-9]*\\)[:].*/\\1/p\'';
                    if ($this->shellManager->setClean()->executeProgram($run)) {
                        $this->getLineMeet($this->shellManager->getResult(), $file, $fileDto->getName());
                    }
                }
            }
        }

        return $this;
    }

    /**
     * $files берем активные из настроек
     *
     * @param array  $lines
     * @param string $file
     * @param string $name
     *
     * @return SearchManager
     * @throws \Exception
     */
    private function getLineMeet(array $lines, $file, $name)
    {
        $message = [];
        foreach ($lines as $number) {
            $run = $this->shellManager->getProgram('sed').' -n \''.$number.','.($number + $this->step).'p;'.($number + $this->step + 1).'q\' '.$file;
            if ($this->shellManager->setClean()->executeProgram($run)) {
                $message[] = $this->shellManager->toUtf8Size();
            }
        }
        if (count($message)) {
            $this->searchResult[] = ['file' => $name, 'messages' => $message];
        }

        return $this;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param LogSearchDto $dto
     *
     * @return $this
     */
    public function setDto($dto): SearchManagerInterface
    {
        $this->dto = $dto;

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return \Evrinoma\SettingsBundle\Entity\Settings[]
     */
    public function getSettings(): array
    {
        $this->loadSettings();

        return $this->settings;
    }

    public function getResult(): array
    {
        $converts = [];
        foreach ($this->getResult() as $value) {
            $string     = preg_replace('/[^[:print:]\r\n]/', '', $value);
            $converts[] = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        }

        return $converts;
    }

    /**
     * @return array
     */
    public function getSearchResult(): array
    {
        return $this->searchResult;
    }

    /**
     * @return $this
     */
    public function getSearch(): SearchManagerInterface
    {
        if ($this->dto) {
            if ($this->dto->isValidSearchStr()) {
                try {
                    $this->loadSettings()->getNumberLineMeet();
                } catch (\Exception $exception) {
                    $this->searchResult[] = $exception->getMessage();
                }
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getRestStatus(): int
    {
        return $this->status;
    }


//endregion Getters/Setters
}