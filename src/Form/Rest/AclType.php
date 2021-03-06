<?php

namespace Evrinoma\EximBundle\Form\Rest;

use Evrinoma\EximBundle\Manager\AclManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AclType extends AbstractType
{
//region SECTION: Fields

    /**
     * @var AclManagerInterface
     */
    private $aclManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * TypeAclType constructor.
     *
     * @param AclManagerInterface $aclManager
     */
    public function __construct(AclManagerInterface $aclManager)
    {
        $this->aclManager = $aclManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $type = [];
            foreach ($this->aclManager->getModel()->getData() as $name) {
                $type[] = $name;
            }

            return $type;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'type');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'type');
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