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
    /**
     * @var FactoryDto
     */
    private $factoryDto;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     *
     * @param FactoryDto    $factoryDto
     * @param ServerManagerInterface $serverManager
     */
    public function __construct(FactoryDto $factoryDto, ServerManagerInterface $serverManager)
    {
        $this->serverManager = $serverManager;
        $this->factoryDto = $factoryDto;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $servers = [];
            $serverDto = $this->factoryDto->cloneDto(ServerDto::class);
            /** @var Server $server */
            foreach ($this->serverManager->get($serverDto)->getData() as $server) {
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