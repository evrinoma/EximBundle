<?php

namespace Evrinoma\EximBundle\Form\Rest;

use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\EximBundle\Dto\ServerDto;
use Evrinoma\EximBundle\Entity\Server;
use Evrinoma\EximBundle\Manager\ServerManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ServerType
 *
 * @package Evrinoma\EximBundle\Form\Rest
 */
class ServerType extends AbstractType
{


    //region SECTION: Fields
    /**
     * @var ServerManagerInterface.
     */
    private $serverManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     *
     * @param ServerManagerInterface $serverManager
     */
    public function __construct(ServerManagerInterface $serverManager)
    {
        $this->serverManager = $serverManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $servers = [];
            /** @var Server $server */
            foreach ($this->serverManager->get(new ServerDto())->getData() as $server) {
                $servers[] = $server->getHostname();
            }

            return $servers;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'server');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'ServerIp');
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