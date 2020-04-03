<?php

namespace Evrinoma\EximBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


/**
 * Class EximController
 *
 * @package Evrinoma\EximBundle\Controller
 */
final class EximController extends AbstractController
{
//region SECTION: Fields
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
//endregion Fields

//region SECTION: Constructor
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
//endregion Constructor

//region SECTION: Public
    public function mailSearch()
    {
        $event = ['titleHeader' => 'Mail', 'pageName' => 'Log Search'];

        return $this->render('@EvrinomaExim/search.html.twig', $event);
    }

    public function mailDomain()
    {
        $event = ['titleHeader' => 'Mail', 'pageName' => 'Domain'];

        return $this->render('@EvrinomaExim/domain.html.twig', $event);
    }

    public function mailAcl()
    {
        $event = ['titleHeader' => 'Mail', 'pageName' => 'System Status'];

        return $this->render('@EvrinomaExim/acl.html.twig', $event);
    }
//endregion Public
}