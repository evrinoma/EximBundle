<?php

namespace Evrinoma\EximBundle\Form\Rest;


use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\EximBundle\Dto\SpamDto;
use Evrinoma\EximBundle\Entity\Filter;
use Evrinoma\EximBundle\Manager\SpamManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FilterType
 *
 * @package Evrinoma\EximBundle\Form\Rest
 */
class FilterType extends AbstractType
{
//region SECTION: Fields
    /**
     * @var FactoryDto
     */
    private $factoryDto;

    /**
     * @var SpamManagerInterface
     */
    private $spamManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     *
     * @param FactoryDto  $factoryDto
     * @param SpamManagerInterface $spamManager
     */
    public function __construct(FactoryDto $factoryDto, SpamManagerInterface $spamManager)
    {
        $this->spamManager = $spamManager;
        $this->factoryDto  = $factoryDto;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $filterTypes = [];
            $spamDto     = $this->factoryDto->cloneDto(SpamDto::class);
            /** @var Filter $rule */
            foreach ($this->spamManager->getType($spamDto)->getData() as $rule) {
                $filterTypes[] = $rule->getType();
            }

            return $filterTypes;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'filter');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'FilterType');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}