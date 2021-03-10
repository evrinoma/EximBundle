<?php

namespace Evrinoma\EximBundle\Dto;

use Evrinoma\DtoBundle\Adaptor\EntityAdaptorInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\EximBundle\Entity\Filter;
use Evrinoma\EximBundle\Entity\Spam;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Storage\StorageInterface;
use Evrinoma\UtilsBundle\Storage\StorageTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SpamDto
 *
 * @package Evrinoma\EximBundle\Dto
 */
class SpamDto extends AbstractDto implements StorageInterface, EntityAdaptorInterface, ActiveInterface
{
    use StorageTrait;

//region SECTION: Fields

    use ActiveTrait;

    private $id;
    /**
     * @Dto(class="Evrinoma\EximBundle\Dto\ConformityDto", generator="genRequestConformityDto")
     * @var ConformityDto
     */
    private $conformity;
    /**
     * @var string
     */
    private $range;
    /**
     * @Dto(class="Evrinoma\EximBundle\Dto\RuleTypeDto", generator="genRequestRuleTypeDto")
     * @var RuleTypeDto
     */
    private $ruleType;
    /**
     * @var string
     */
    private $spamRecord;

//region SECTION: Public

    /**
     * @param Spam $entity
     */
    public function fillEntity($entity): void
    {
        $entity
            ->setConformity($this->getConformity()->generatorEntity()->current())
            ->setType($this->getRuleType()->generatorEntity()->current())
            ->setDomain($this->getSpamRecord())
            ->setUpdateAt(new \DateTime('now'))
            ->setActive($this->getActive());
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $valid = false;
        if ($this->spamRecord) {
            if ($this->getRuleType() && $this->getRuleType()->hasSingleEntity()) {
                /** @var Filter $entity */
                $entity = $this->getRuleType()->generatorEntity()->current();
                if ($entity->isPatternBurn() && $this->isBurn()) {
                    $valid = true;
                }
                if ($entity->isPatternIP() && $this->isRange()) {
                    $this->setSpamRecord($this->range);
                    $valid = true;
                }
                if ($entity->isPattern() && $this->isHostName()) {
                    $valid = true;
                }
            }
        }

        return $valid;
    }

    /**
     * @return bool
     */
    public function isBurn()
    {
        return $this->spamRecord && $this->spamRecord !== '';
    }

    /**
     * @return bool
     */
    public function isHostName()
    {
        return $this->spamRecord && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->spamRecord) === 1);
    }

//endregion Public

//region SECTION: Private
    private function isRange()
    {
        if (strpos($this->spamRecord, '/') === false) {
            $range = '/32';
        } else {
            list($this->spamRecord, $range) = explode('/', $this->spamRecord, 2);
        }
        if (filter_var($this->spamRecord, FILTER_VALIDATE_IP)) {
            switch ($range) {
                case 24:
                    $limit       = 4;
                    $this->range = $this->formatIp(explode('.', $this->spamRecord, $limit), $limit);
                    break;
                case 16:
                    $limit       = 3;
                    $this->range = $this->formatIp(explode('.', $this->spamRecord, $limit), $limit);
                    break;
                case 8:
                    $limit       = 2;
                    $this->range = $this->formatIp(explode('.', $this->spamRecord, $limit), $limit);
                    break;
            }

            return true;
        }

        return false;
    }

    /**
     * @param $range
     * @param $count
     *
     * @return string
     */
    private function formatIp($range, $count)
    {
        $ip = '';
        for ($i = 0; $i < ($count - 1); $i++) {
            $ip .= $range[$i].'.';

        }

        return $ip;
    }

    /**
     * @param string $spamRecord
     *
     * @return SpamDto
     */
    private function setSpamRecord(string $spamRecord)
    {
        $this->spamRecord = $spamRecord;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return SpamDto
     */
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }
//endregion Private
//endregion Private

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto($request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {

            $spamId     = $request->get('id');
            $active     = $request->get('active');
            $spamRecord = $request->get('spamRecord');

            if ($spamId) {
                $this->setId($spamId);
            }

            if ($active) {
                $this->setActive($active);
            }

            if ($spamRecord) {
                $this->setSpamRecord($spamRecord);
            }
        }

        return $this;
    }

    /**
     * @return \Generator
     */
    public function genRequestConformityDto(?Request $request): ?\Generator
    {
        if ($request) {
            $server = $request->get('conformity');
            if ($server) {
                $newRequest                      = $this->getCloneRequest();
                $server[DtoInterface::DTO_CLASS] = ConformityDto::class;
                $newRequest->request->add($server);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestRuleTypeDto(?Request $request): ?\Generator
    {
        if ($request) {
            $server = $request->get('filter');
            if ($server) {
                $newRequest                      = $this->getCloneRequest();
                $server[DtoInterface::DTO_CLASS] = RuleTypeDto::class;
                $newRequest->request->add($server);

                yield $newRequest;
            }
        }
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getClassEntity(): string
    {
        return Spam::class;
    }

    /**
     * @return string
     */
    public function getSpamRecord()
    {
        return $this->spamRecord;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ConformityDto
     */
    public function getConformity(): ?ConformityDto
    {
        return $this->conformity;
    }

    /**
     * @return RuleTypeDto
     */
    public function getRuleType(): ?RuleTypeDto
    {
        return $this->ruleType;
    }

    /**
     * @param ConformityDto $conformity
     *
     * @return SpamDto
     */
    public function setConformity(ConformityDto $conformity): self
    {
        $this->conformity = $conformity;

        return $this;
    }

    /**
     * @param RuleTypeDto $ruleType
     *
     * @return SpamDto
     */
    public function setRuleType(RuleTypeDto $ruleType): self
    {
        $this->ruleType = $ruleType;

        return $this;
    }
//endregion Getters/Setters
}