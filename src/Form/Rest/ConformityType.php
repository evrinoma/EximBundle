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
 * Class ConformityType
 *
 * @package Evrinoma\EximBundle\Form\Rest
 */
class ConformityType extends AbstractType
{
//region SECTION: Fields
    /**
     * @var SpamManagerInterface
     */
    private $spamManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     *
     * @param SpamManagerInterface $spamManager
     */
    public function __construct(SpamManagerInterface $spamManager)
    {
        $this->spamManager = $spamManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $conformists = [];
            /** @var Filter $rule */
            foreach ($this->spamManager->getConformity(new SpamDto())->getData() as $rule) {
                $conformists[] = $rule->getType();
            }

            return $conformists;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'conformity');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'conformityType');
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