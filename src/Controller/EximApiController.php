<?php

namespace Evrinoma\EximBundle\Controller;

use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\EximBundle\Dto\AclDto;
use Evrinoma\EximBundle\Dto\DomainDto;
use Evrinoma\EximBundle\Dto\LogSearchDto;
use Evrinoma\EximBundle\Dto\ServerDto;
use Evrinoma\EximBundle\Dto\SpamDto;
use Evrinoma\EximBundle\Manager\AclManagerInterface;
use Evrinoma\EximBundle\Manager\DomainManagerInterface;
use Evrinoma\EximBundle\Manager\SearchManagerInterface;
use Evrinoma\EximBundle\Manager\ServerManagerInterface;
use Evrinoma\EximBundle\Manager\SpamManagerInterface;
use Evrinoma\EximBundle\Vuetable\AdaptorVuetable;
use Evrinoma\EximBundle\Vuetable\VuetableInterface;
use Evrinoma\SettingsBundle\Dto\SettingsDto;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class EximApiController
 *
 * @package Evrinoma\EximBundle\Controller
 */
final class EximApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var FactoryDto
     */
    private $factoryDto;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var AclManagerInterface
     */
    private $aclManager;
    /**
     * @var DomainManagerInterface
     */
    private $domainManager;

    /**
     * @var ServerManagerInterface
     */
    private $serverManager;

    /**
     * @var SpamManagerInterface
     */
    private $spamManager;

    /**
     * @var SearchManagerInterface
     */
    private $searchManager;
//endregion Fields

//region SECTION: Constructor

    /**
     * ApiController constructor.
     *
     * @param SerializerInterface    $serializer
     * @param RequestStack           $requestStack
     * @param FactoryDto             $factoryDto
     * @param AclManagerInterface    $aclManager
     * @param DomainManagerInterface $domainManager
     * @param ServerManagerInterface $serverManager
     * @param SpamManagerInterface   $spamManager
     * @param SearchManagerInterface $searchManager
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDto $factoryDto,
        AclManagerInterface $aclManager,
        DomainManagerInterface $domainManager,
        ServerManagerInterface $serverManager,
        SpamManagerInterface $spamManager,
        SearchManagerInterface $searchManager
    ) {
        parent::__construct($serializer);
        $this->request    = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->aclManager = $aclManager;
        $this->domainManager = $domainManager;
        $this->serverManager = $serverManager;
        $this->spamManager = $spamManager;
        $this->searchManager = $searchManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Get("/api/exim/acl/acl", name="api_acl")
     * @SWG\Get(tags={"acl"})
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\AclDto[id]",
     *     in="query",
     *     type="string",
     *     description="id record"
     * )
     * @SWG\Response(response=200,description="Returns the acl list")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function aclAction()
    {
        $aclDto = $this->factoryDto->setRequest($this->request)->createDto(AclDto::class);

        return $this->json($this->aclManager->setRestSuccessOk()->get($aclDto)->getData(), $this->aclManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/acl/class", name="api_acl_class")
     * @SWG\Get(tags={"acl"})
     * @SWG\Response(response=200,description="Returns class acl entity")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function aclClassAction()
    {
        return $this->json($this->aclManager->setRestSuccessOk()->getRepositoryClass(), $this->aclManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/acl/model", name="api_acl_model")
     * @SWG\Get(tags={"acl"})
     *
     * @SWG\Response(response=200,description="Returns the acl model")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function aclModelAction()
    {
        return $this->json($this->aclManager->setRestSuccessOk()->getModel()->toModel(), $this->aclManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/acl/save", name="api_acl_save")
     * @SWG\Post(tags={"acl"})
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\AclDto[id]",
     *     in="query",
     *     type="string",
     *     description="id record"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\AclDto[email]",
     *     in="query",
     *     type="string",
     *     description="email or domain record"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\AclDto[type]",
     *     in="query",
     *     type="array",
     *     description="black or white",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\TypeAclType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\DomainDto[domain]",
     *     in="query",
     *     type="array",
     *     description="select domain",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\DomainType::class)
     *     )
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function aclSaveAction()
    {
        $aclDto = $this->factoryDto->setRequest($this->request)->createDto(AclDto::class);

        return $this->json($this->aclManager->setRestSuccessOk()->toSave($aclDto), $this->aclManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/domain/domain", name="api_domain")
     * @SWG\Get(tags={"domain"})
     *
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainAction()
    {
        $domainDto = $this->factoryDto->setRequest($this->request)->createDto(DomainDto::class);

        return $this->json($this->domainManager->setRestSuccessOk()->get($domainDto)->getData(), $this->domainManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/domain/class", name="api_domain_class")
     * @SWG\Get(tags={"domain"})
     *
     * @SWG\Response(response=200,description="Returns the class domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainClassAction()
    {
        return $this->json($this->domainManager->setRestSuccessOk()->getRepositoryClass(), $this->domainManager->getRestStatus());
    }


    /**
     * @Rest\Get("/api/exim/domain/query", name="api_query_domain")
     * @SWG\Get(tags={"domain"})
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\DomainDto[page]",
     *     in="query",
     *     type="integer",
     *     default="1",
     *     description="page number"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\DomainDto[per_page]",
     *     in="query",
     *     type="integer",
     *     default="0",
     *     description="per page records"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\DomainDto[filter]",
     *     in="query",
     *     type="string",
     *     default="",
     *     description="filter by domain or mx"
     * )
     *
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainByQueryAction()
    {
        /** @var VuetableInterface $domainDto */
        $domainDto = $this->factoryDto->setRequest($this->request)->createDto(DomainDto::class);
        $this->domainManager->get($domainDto);

        $response = (new AdaptorVuetable($this->domainManager, $domainDto, $this->domainManager->getData()))->toVuetable();

        $this->domainManager->setRestSuccessOk();

        return $this->json($response, $this->domainManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/exim/domain/delete", name="api_delete_domain")
     * @SWG\Delete(tags={"domain"})
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\DomainDto[id]",
     *     in="query",
     *     type="string",
     *     default="-1",
     *     description="id record"
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainDeleteAction()
    {
        $domainDto = $this->factoryDto->setRequest($this->request)->createDto(DomainDto::class);

        $this->domainManager->setRestSuccessOk()->get($domainDto)->lockEntitys();

        return $this->json(['message' => 'the Domain was delete successFully'], $this->domainManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/domain/save", name="api_save_domain")
     * @SWG\Post(tags={"domain"})
     * @SWG\Parameter(
     *  name="Evrinoma\EximBundle\Dto\ServerDto[hostname]",
     *     in="query",
     *     type="array",
     *     description="This is a parameter",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\ServerType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\DomainDto[domain]",
     *     in="query",
     *     type="string",
     *     default="ite-ng.ru",
     *     description="Mail name server"
     * )
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"domainName": "ite29.ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     * @SWG\Response(response=400,description="set ip and name domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function domainSaveAction()
    {
        $domainDto = $this->factoryDto->setRequest($this->request)->createDto(DomainDto::class);

        return $this->json(
            ['domains' => $this->domainManager->setRestSuccessOk()->toSave($domainDto)],
            $this->domainManager->getRestStatus()
        );
    }

    /**
     * @Rest\Get("/api/exim/log/search", name="api_log_search")
     * @SWG\Get(tags={"log"})
     * @SWG\Parameter(
     *     name="searchString",
     *     in="query",
     *     type="string",
     *     default="@ite-ng.ru",
     *     description="search for"
     * )
     * @SWG\Parameter(
     *     name="searchFile",
     *     in="query",
     *     type="array",
     *     description="search there",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\FileSearchType::class, options={"rest_class_entity":"Evrinoma\EximBundle\Dto\LogSearchDto"})
     *     )
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearchAction()
    {
        $logSearch = $this->factoryDto->setRequest($this->request)->createDto(LogSearchDto::class);

        return $this->json(
            [
                'search' => $this->searchManager->setRestSuccessOk()
                    ->setDto($logSearch)
                    ->getSearch()
                    ->getSearchResult(),
            ],
            $this->searchManager->getRestStatus()
        );
    }

    /**
     * @Rest\Get("/api/exim/log/settings", name="api_log_settings")
     * @SWG\Get(tags={"log"})
     *
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearchSettingsAction()
    {
        $logSearchDto = $this->factoryDto->setRequest($this->request)->createDto(LogSearchDto::class);

        return $this->json(['settings' => $this->searchManager->setRestSuccessOk()->setDto($logSearchDto)->getSettings(), 'classEntity' => LogSearchDto::class], $this->searchManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/log/settings/save", name="api_save_settings")
     * @SWG\Post(tags={"log"})
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * required=true,
     *      @SWG\Schema(
     *          @SWG\Property(
     *          property="settings",
     *          type="array",
     *          @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="string", ),
     *              @SWG\Property(property="active", type="string",),
     *              ),
     *          ),
     *      ),
     *  ),
     *
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearchSettingsSaveAction()
    {
        $settingsDto = $this->factoryDto->setRequest($this->request)->createDto(SettingsDto::class);

        return $this->json(['settings' => $this->searchManager->setRestSuccessOk()->setDto($settingsDto)->saveSettings()], $this->searchManager->getRestStatus());
    }


    /**
     * @Rest\Get("/api/exim/server/server", name="api_server")
     * @SWG\Get(tags={"server"})
     * @SWG\Response(response=200,description="Returns the rewards of all servers")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function serverAction()
    {
        $serverDto = $this->factoryDto->setRequest($this->request)->createDto(ServerDto::class);

        return $this->json(['servers' => $this->serverManager->setRestSuccessOk()->get($serverDto)->getData()], $this->serverManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/server/class", name="api_server_class")
     * @SWG\Get(tags={"server"})
     *
     * @SWG\Response(response=200,description="Returns the class domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function serverClassAction()
    {
        return $this->json($this->serverManager->setRestSuccessOk()->getRepositoryClass(), $this->serverManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/exim/server/delete", name="api_delete_server")
     * @SWG\Delete(tags={"server"})
     * @SWG\Parameter(
     *  name="Evrinoma\EximBundle\Dto\ServerDto[hostname]",
     *     in="query",
     *     type="array",
     *     description="This is a parameter",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\ServerType::class)
     *     )
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function serverDeleteAction()
    {
        $serverDto = $this->factoryDto->setRequest($this->request)->createDto(ServerDto::class);

        $this->serverManager->setRestSuccessOk()->get($serverDto)->lockEntitys();

        return $this->json(['message' => 'the Domain was delete successFully'], $this->serverManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/server/save", name="api_save_server")
     * @SWG\Post(tags={"server"})
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\ServerDto[id]",
     *     in="query",
     *     type="string",
     *     default=null,
     *     description="id server"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\ServerDto[ip]",
     *     in="query",
     *     type="string",
     *     pattern="\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}",
     *     default="172.20.1.4",
     *     description="ip server"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\ServerDto[hostname]",
     *     in="query",
     *     type="string",
     *     default="mail.ite-ng.ru",
     *     description="hostname server"
     * )
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"hostNameServer": "ite-ng.ru", "ipServer": "172.20.1.4"}
     *     )
     * )
     * @SWG\Response(response=400,description="set ip and name domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function serverSaveAction()
    {
        $serverDto = $this->factoryDto->setRequest($this->request)->createDto(ServerDto::class);

        return $this->json(
            ['servers' => $this->serverManager->setRestSuccessOk()->toSave($serverDto)],
            $this->serverManager->getRestStatus()
        );
    }

    /**
     * @Rest\Get("/api/exim/spam/rules", name="api_spam_rules")
     * @SWG\Get(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the spam rules")
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\RuleTypeDto[type]",
     *     in="query",
     *     type="array",
     *     description="select spam filter type",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\FilterType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\ConformityDto[type]",
     *     in="query",
     *     type="array",
     *     description="select spam conformity type",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\ConformityType::class)
     *     )
     * )
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesAction()
    {
        $spamDto = $this->factoryDto->setRequest($this->request)->createDto(SpamDto::class);

        return $this->json($this->spamManager->setRestSuccessOk()->get($spamDto)->getData(), $this->spamManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/spam/class", name="api_spam_rules_class")
     * @SWG\Get(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the spam rules class")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesClassAction()
    {
        return $this->json($this->spamManager->setRestSuccessOk()->getRepositoryClass(), $this->spamManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/spam/conformity", name="api_spam_rules_conformity")
     * @SWG\Get(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the spam rules conformity")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesConformityAction()
    {
        $spamDto = $this->factoryDto->setRequest($this->request)->createDto(SpamDto::class);

        return $this->json($this->spamManager->setRestSuccessOk()->getConformity($spamDto)->toModel(), $this->spamManager->getRestStatus());
    }


    /**
     * @Rest\Post("/api/exim/spam/save", name="api_save_spam")
     * @SWG\Post(tags={"spam"})
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\SpamDto[id]",
     *     in="query",
     *     type="string",
     *     default=null,
     *     description="id spam"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\SpamDto[spamRecord]",
     *     in="query",
     *     type="string",
     *     default=null,
     *     description="spam Record"
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\RuleTypeDto[type]",
     *     in="query",
     *     type="array",
     *     description="select spam filter type",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\FilterType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="Evrinoma\EximBundle\Dto\ConformityDto[type]",
     *     in="query",
     *     type="array",
     *     description="select spam conformity type",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=Evrinoma\EximBundle\Form\Rest\ConformityType::class)
     *     )
     * )
     * @SWG\Response(response=400,description="set ip and name domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesSaveAction()
    {
        $spamDto = $this->factoryDto->setRequest($this->request)->createDto(SpamDto::class);

        return $this->json($this->spamManager->setRestSuccessOk()->toSave($spamDto), $this->spamManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/spam/rules_type", name="api_spam_rules_type")
     * @SWG\Get(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the spam rules types")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesTypeAction()
    {
        $spamDto = $this->factoryDto->setRequest($this->request)->createDto(SpamDto::class);

        return $this->json($this->spamManager->setRestSuccessOk()->getType($spamDto)->getData(), $this->spamManager->getRestStatus());
    }
//endregion Public
}