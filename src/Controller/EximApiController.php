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
use OpenApi\Annotations as OA;
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
        $this->request       = $requestStack->getCurrentRequest();
        $this->factoryDto    = $factoryDto;
        $this->aclManager    = $aclManager;
        $this->domainManager = $domainManager;
        $this->serverManager = $serverManager;
        $this->spamManager   = $spamManager;
        $this->searchManager = $searchManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Get("/api/exim/acl/acl", name="api_acl")
     * @OA\Get(
     *      tags={"acl"},
     *      @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\AclDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="ID acl record",
     *         in="query",
     *         name="aclId",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Returns the acl list")
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
     * @OA\Get(tags={"acl"}, deprecated=true)
     * @OA\Response(response=200,description="Returns class acl entity")
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
     * @OA\Get(tags={"acl"})
     *
     * @OA\Response(response=200,description="Returns the acl model")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function aclModelAction()
    {
        return $this->json($this->aclManager->setRestSuccessOk()->getModel()->toModel(), $this->aclManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/acl/save", name="api_acl_save")
     * @OA\Post(
     *      tags={"acl"},
     *     description="the method perform save acl",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\EximBundle\Dto\AclDto",
     *                  "domain":"ite-ng.ru",
     *                  "type":"white",
     *                  "email":"test@test.ru",
     *                  "aclId":"2"
     *               },
     *               @OA\Property(property="class",type="string", description="class", default="Evrinoma\EximBundle\Dto\AclDto"),
     *               @OA\Property(property="domain",type="string", description="select domain"),
     *               @OA\Property(property="type",type="string", description="select domain"),
     *               @OA\Property(property="email",type="string", description="email or domain record"),
     *               @OA\Property(property="aclId",type="string", description="ID acl record")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Returns nothing")
     *
     *
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
     * @OA\Get(tags={"domain"},
     *      @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\DomainDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="ID record",
     *         in="query",
     *         name="domainId",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200,description="Returns the rewards of all generated domains")
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
     * @OA\Get(tags={"domain"}, deprecated=true)
     *
     * @OA\Response(response=200,description="Returns the class domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainClassAction()
    {
        return $this->json($this->domainManager->setRestSuccessOk()->getRepositoryClass(), $this->domainManager->getRestStatus());
    }


    /**
     * @Rest\Get("/api/exim/domain/query", name="api_query_domain")
     * @OA\Get(
     *      tags={"domain"},
     *      @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\DomainDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="page number",
     *         in="query",
     *         name="page",
     *         @OA\Schema(
     *           type="integer",
     *           default="1",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="per page records",
     *         in="query",
     *         name="per_page",
     *         @OA\Schema(
     *           type="integer",
     *           default="0",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="filter by domain or mx",
     *         in="query",
     *         name="filter",
     *         @OA\Schema(
     *           type="filter by domain or mx",
     *           default="",
     *         )
     *     ),
     * )
     *
     * @OA\Response(response=200,description="Returns the rewards of all generated domains")
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
     * @OA\Delete(
     *     tags={"domain"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\DomainDto",
     *           readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id record",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           default="-1",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Returns nothing")
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
     * @OA\Post(
     *     tags={"domain"}),
     * @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\DomainDto",
     *           readOnly=true
     *         )
     *     ),
     * @OA\Parameter(
     *         name="hostname",
     *         in="query",
     *         description="This is a parameter",
     *         required=true,
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\EximBundle\Form\Rest\ServerType::class),
     *              ),
     *          ),
     *         style="form"
     *     ),
     * @OA\Parameter(
     *         description="Mail name server",
     *         in="query",
     *         name="domain",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="ite-ng.ru",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Returns the rewards of default generated domain",
     *     @OA\Schema(
     *        type="object",
     *        example={"domainName": "ite29.ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     * @OA\Response(response=400,description="set ip and name domain")
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
     * @OA\Get(
     *     tags={"log"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\DomainDto",
     *           readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="search for",
     *         in="query",
     *         name="searchString",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="@ite-ng.ru",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="searchFile",
     *         in="query",
     *         description="search there",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(
     *                      type=Evrinoma\EximBundle\Form\Rest\FileSearchType::class,
     *                      options={"rest_class_entity":"Evrinoma\EximBundle\Dto\LogSearchDto"}
     *                  ),
     *              ),
     *          ),
     *         style="form"
     *     ),
     * )
     * @OA\Response(response=200,description="Returns nothing")
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
     * @OA\Get(tags={"log"})
     *
     * @OA\Response(response=200,description="Returns nothing")
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
     * @OA\Post(
     *      tags={"log"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={"classEntity":"Evrinoma\EximBundle\Dto\LogSearchDto","settings":{{"id":"41","active":"b"},{"id":"42","active":"d"},{"id":"43","active":"a"}}},
     *               type="object",
     *               @OA\Property(property="classEntity",type="string"),
     *               @OA\Property(
     *                  property="settings",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id",type="string"),
     *                      @OA\Property(property="active",type="string")
     *                   )
     *               )
     *            )
     *
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Returns nothing")
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
     * @OA\Get(tags={"server"})
     * @OA\Response(response=200,description="Returns the rewards of all servers")
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
     * @OA\Get(tags={"server"}, deprecated=true)
     *
     * @OA\Response(response=200,description="Returns the class domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function serverClassAction()
    {
        return $this->json($this->serverManager->setRestSuccessOk()->getRepositoryClass(), $this->serverManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/exim/server/delete", name="api_delete_server")
     * @OA\Delete(
     *     tags={"server"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\ServerDto",
     *           readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="hostname",
     *         in="query",
     *         description="This is a parameter",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\EximBundle\Form\Rest\ServerType::class),
     *              ),
     *          ),
     *         style="form"
     *     )
     *  )
     *
     * @OA\Response(response=200,description="Returns nothing")
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
     * @OA\Post(
     *      tags={"server"},
     *      @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\ServerDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id server",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *           type="string",
     *           default=null,
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="ip server",
     *         in="query",
     *         name="ip",
     *         @OA\Schema(
     *           type="string",
     *           pattern="\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}",
     *           default="172.20.1.4",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="hostname server",
     *         in="query",
     *         name="hostname",
     *         @OA\Schema(
     *           type="string",
     *           default="mail.ite-ng.ru",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Returns the rewards of default generated domain",
     *     @OA\Schema(
     *        type="object",
     *        example={"hostNameServer": "ite-ng.ru", "ipServer": "172.20.1.4"}
     *     )
     * )
     * @OA\Response(response=400,description="set ip and name domain")
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
     * @OA\Get(
     *     tags={"spam"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\RuleTypeDto",
     *           readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="select spam conformity type",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\EximBundle\Form\Rest\FilterType::class),
     *              ),
     *          ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="select spam conformity type",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\EximBundle\Form\Rest\ConformityType::class),
     *              ),
     *          ),
     *         style="form"
     *     ),
     * )
     * @OA\Response(response=200,description="Returns the spam rules")
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
     * @OA\Get(tags={"spam"}, deprecated=true)
     * @OA\Response(response=200,description="Returns the spam rules class")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesClassAction()
    {
        return $this->json($this->spamManager->setRestSuccessOk()->getRepositoryClass(), $this->spamManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/exim/spam/conformity", name="api_spam_rules_conformity")
     * @OA\Get(tags={"spam"})
     * @OA\Response(response=200,description="Returns the spam rules conformity")
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
     * @OA\Post(
     *     tags={"spam"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\EximBundle\Dto\SpamDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id spam",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *           type="string",
     *           default=null,
     *         )
     *      ),
     *      @OA\Parameter(
     *         description="spam Record",
     *         in="query",
     *         name="spamRecord",
     *         @OA\Schema(
     *           type="string",
     *           default=null,
     *         )
     *      ),
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="select spam filter type",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\EximBundle\Form\Rest\FilterType::class),
     *              ),
     *          ),
     *         style="form"
     *     ),
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="select spam conformity type",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\EximBundle\Form\Rest\ConformityType::class),
     *              ),
     *          ),
     *         style="form"
     *     ),
     * )
     * @OA\Response(response=400,description="set ip and name domain")
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
     * @OA\Get(tags={"spam"})
     * @OA\Response(response=200,description="Returns the spam rules types")
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