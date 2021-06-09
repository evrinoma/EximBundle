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
     *         name="id",
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

        return $this->json($this->aclManager->setRestOk()->get($aclDto)->getData(), $this->aclManager->getRestStatus());
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
        return $this->json($this->aclManager->setRestOk()->getModel()->toModel(), $this->aclManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/acl/save", name="api_acl_save")
     * @OA\Post(
     *      tags={"acl"},
     *      description="the method perform save acl",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  example={
     *                      "class":"Evrinoma\EximBundle\Dto\AclDto",
     *                      "type":"white",
     *                      "email":"test@test.ru",
     *                      "id":"2",
     *                      "domain":{
     *                          "id":"2",
     *                          "domain":"lazurnoe.net",
     *                          "server":{
     *                              "id":"2",
     *                              "hostname":"email.ite-ng.ru",
     *                              "ip":"172.20.1.4",
     *                          }
     *                      }
     *                  },
     *                  @OA\Property(property="class",type="string", description="class", default="Evrinoma\EximBundle\Dto\AclDto"),
     *                  @OA\Property(property="type",type="string", description="select domain"),
     *                  @OA\Property(property="email",type="string", description="email or domain record"),
     *                  @OA\Property(property="id",type="string", description="ID acl record"),
     *                  @OA\Property(
     *                      property="domain",
     *                      type="object",
     *                      @OA\Property(property="id",type="string", description="id domain"),
     *                      @OA\Property(property="domain",type="string", description="domain name"),
     *                      @OA\Property(
     *                          property="server",
     *                          type="object",
     *                          @OA\Property(property="id",type="string", description="id server"),
     *                          @OA\Property(property="ip",type="string", description="ip server"),
     *                          @OA\Property(property="hostname",type="string", description="hostname server"),
     *                      )
     *                  )
     *               )
     *            )
     *         )
     *     )
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

        return $this->json($this->aclManager->setRestOk()->toSave($aclDto), $this->aclManager->getRestStatus());
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
     *         name="id",
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

        return $this->json($this->domainManager->setRestOk()->get($domainDto)->getData(), $this->domainManager->getRestStatus());
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

        return $this->json((new AdaptorVuetable($this->domainManager, $domainDto, $this->domainManager->getData()))->toVuetable(), $this->domainManager->setRestOk()->getRestStatus());
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

        $em   = $this->getDoctrine()->getManager();
        $domainManager = $this->domainManager;

        $em->transactional(
            function () use ($domainDto, $domainManager) {
                $domainManager->setRestOk()->get($domainDto)->lockEntities();
            }
        );


        return $this->json(['message' => 'the Domain was delete successFully'], $this->domainManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/domain/save", name="api_save_domain")
     * @OA\Post(
     *      tags={"domain"}),
     *      description="the method perform save domain",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\EximBundle\Dto\DomainDto",
     *                  "id":"2",
     *                  "domain":"lazurnoe.net",
     *                  "server":{
     *                          "id":"2",
     *                          "hostname":"email.ite-ng.ru",
     *                          "ip":"172.20.1.4",
     *                   }
     *               },
     *               @OA\Property(property="class",type="string", description="class", default="Evrinoma\EximBundle\Dto\ServerDto"),
     *               @OA\Property(property="id",type="string", description="id domain"),
     *               @OA\Property(property="domain",type="string", description="domain name"),
     *               @OA\Property(
     *                  property="server",
     *                  type="object",
     *                  @OA\Property(property="id",type="string", description="id server"),
     *                  @OA\Property(property="ip",type="string", description="ip server"),
     *                  @OA\Property(property="hostname",type="string", description="hostname server"),
     *                )
     *            )
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
            ['domains' => $this->domainManager->setRestOk()->toSave($domainDto)],
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
     *           default="Evrinoma\EximBundle\Dto\LogSearchDto",
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
     *         name="searchFiles[]",
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
                'search' => $this->searchManager->setRestOk()
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

        return $this->json(['settings' => $this->searchManager->setRestOk()->setDto($logSearchDto)->getSettings(), 'classDto' => LogSearchDto::class], $this->searchManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/log/settings/save", name="api_save_settings")
     * @OA\Post(
     *      tags={"log"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={"class":"Evrinoma\EximBundle\Dto\LogSearchDto","searchFiles":{{"fileId":"41","active":"b"},{"fileId":"42","active":"d"},{"fileId":"43","active":"a"}}},
     *               type="object",
     *               @OA\Property(property="class",type="string"),
     *               @OA\Property(
     *                  property="searchFiles",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="fileId",type="string"),
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
        $settingsDto = $this->factoryDto->setRequest($this->request)->createDto(LogSearchDto::class);

        return $this->json(['settings' => $this->searchManager->setRestOk()->setDto($settingsDto)->saveSettings()], $this->searchManager->getRestStatus());
    }


    /**
     * @Rest\Get("/api/exim/server/server", name="api_server")
     * @OA\Get(tags={"server"},
     *       @OA\Parameter(
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
     *         description="ID record",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Returns the rewards of all servers")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function serverAction()
    {
        $serverDto = $this->factoryDto->setRequest($this->request)->createDto(ServerDto::class);

        return $this->json(['servers' => $this->serverManager->setRestOk()->get($serverDto)->getData()], $this->serverManager->getRestStatus());
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

        $em   = $this->getDoctrine()->getManager();
        $serverManager = $this->serverManager;

        $em->transactional(
            function () use ($serverDto, $serverManager) {
                $serverManager->setRestOk()->get($serverDto)->lockEntities();
            }
        );

        return $this->json(['message' => 'the Domain was delete successFully'], $this->serverManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/server/save", name="api_save_server")
     * @OA\Post(
     *      tags={"server"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\EximBundle\Dto\ServerDto",
     *                  "id":"2",
     *                  "ip":"172.20.1.4",
     *                  "hostname":"mail.ite-ng.ru",
     *               },
     *               @OA\Property(property="class",type="string", description="class", default="Evrinoma\EximBundle\Dto\ServerDto"),
     *               @OA\Property(property="id",type="string", description="id server", default=""),
     *               @OA\Property(property="ip",type="string", description="ip server"),
     *               @OA\Property(property="hostname",type="string", description="hostname server"),
     *            )
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
            ['servers' => $this->serverManager->setRestOk()->toSave($serverDto)],
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
     *           default="Evrinoma\EximBundle\Dto\SpamDto",
     *           readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="filter[filterType]",
     *         in="query",
     *         description="select spam Filter type",
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
     *         name="conformity[conformityType]",
     *         in="query",
     *         description="select spam Conformity type",
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

        return $this->json($this->spamManager->setRestOk()->get($spamDto)->getData(), $this->spamManager->getRestStatus());
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

        return $this->json($this->spamManager->setRestOk()->getConformity($spamDto)->toModel(), $this->spamManager->getRestStatus());
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

        return $this->json($this->spamManager->setRestOk()->getType($spamDto)->getData(), $this->spamManager->getRestStatus());
    }

    /**
     * @Rest\Post("/api/exim/spam/save", name="api_save_spam")
     * @OA\Post(
     *     tags={"spam"},
     *      description="the method perform save spam rule",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\EximBundle\Dto\SpamDto",
     *                  "id":"2",
     *                  "active":"b",
     *                  "spamRecord":"test.ru",
     *                  "conformity":{
     *                          "conformityType":"soft",
     *                   },
     *                  "filter":{
     *                          "filterType":"helo",
     *                   }
     *               },
     *               @OA\Property(property="class",type="string", description="class", default="Evrinoma\EximBundle\Dto\ServerDto"),
     *               @OA\Property(property="id",type="string", description="id spam"),
     *               @OA\Property(property="spamRecord",type="string", description="spam Record"),
     *               @OA\Property(property="active",type="string", description="status spam rule"),
     *               @OA\Property(
     *                  property="conformity",
     *                  type="object",
     *                  @OA\Property(property="conformityType",type="string", description="select spam Conformity type"),
     *                ),
     *               @OA\Property(
     *                  property="filter",
     *                  type="object",
     *                  @OA\Property(property="filterType",type="string", description="select spam Filter type"),
     *                )
     *            )
     *         )
     *     )
     * )
     *
     * @OA\Response(response=400,description="set spamRecord, filterType and conformityType domain")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesSaveAction()
    {
        $spamDto = $this->factoryDto->setRequest($this->request)->createDto(SpamDto::class);

        return $this->json($this->spamManager->setRestOk()->toSave($spamDto), $this->spamManager->getRestStatus());
    }


    /**
     * @Rest\Delete("/api/exim/spam/delete", name="api_delete_spam")
     * @OA\Delete(
     *     tags={"spam"},
     *     description="the method perform delete spam rule",
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
    public function spamDeleteAction()
    {
        $spamDto = $this->factoryDto->setRequest($this->request)->createDto(SpamDto::class);

        $em   = $this->getDoctrine()->getManager();
        $spamManager = $this->spamManager;

        $em->transactional(
            function () use ($spamDto, $spamManager) {
                $spamManager->setRestOk()->get($spamDto)->lockEntities();
            }
        );

        return $this->json(['message' => 'the Spam rule was delete successFully'], $this->spamManager->getRestStatus());
    }
//endregion Public
}