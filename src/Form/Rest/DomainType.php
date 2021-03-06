<?php

namespace Evrinoma\EximBundle\Form\Rest;

use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\EximBundle\Dto\DomainDto;
use Evrinoma\EximBundle\Entity\Domain;
use Evrinoma\EximBundle\Manager\DomainManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DomainType
 *
 * @package Evrinoma\EximBundle\Form\Rest
 */
class DomainType extends AbstractType
{
//region SECTION: Fields

    private $domainManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * DomainType constructor.
     *
     * @param DomainManagerInterface $domainManager
     */
    public function __construct(DomainManagerInterface $domainManager)
    {
        $this->domainManager = $domainManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $domains   = [];
            /** @var Domain $domain */
            foreach ($this->domainManager->get(new DomainDto())->getData() as $domain) {
                $domains[] = $domain->getDomainName();
            }

            return $domains;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'domainName');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'domainName');
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