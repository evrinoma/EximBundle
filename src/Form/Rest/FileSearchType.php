<?php

namespace Evrinoma\EximBundle\Form\Rest;

use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\EximBundle\Dto\ApartDto\FileDto;
use Evrinoma\SettingsBundle\Dto\SettingsDto;
use Evrinoma\SettingsBundle\Manager\SettingsManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FileSearchType
 *
 * @package AEvrinoma\EximBundle\Form\Rest
 */
class FileSearchType extends AbstractType
{
//region SECTION: Fields
    public const REST_CLASS_ENTITY = 'rest_class_entity';
    /**
     * @var SettingsManagerInterface
     */
    private $settingsManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     */
    public function __construct(SettingsManagerInterface $settingsManager = null)
    {
        $this->settingsManager = $settingsManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $fileList = [];
            $class    = $options->offsetGet(self::REST_CLASS_ENTITY);
            if ($class) {
                foreach ($this->settingsManager->getSettings(new SettingsDto()) as $file) {
                    $data = $file->getData();
                    if ($data instanceof FileDto) {
                        /** @var $data FileDto */
                        $fileList[] = $data->getName();
                    }
                }
            }

            return $fileList;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'fileSearch');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'fileSearchList');
        $resolver->setDefault(self::REST_CLASS_ENTITY, null);
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}