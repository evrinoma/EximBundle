<?php


namespace Evrinoma\EximBundle\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Menu\MenuInterface;
use Evrinoma\UtilsBundle\Voter\RoleInterface;

/**
 * Class EximMenu
 *
 * @package Evrinoma\EximBundle\Menu
 */
final class EximMenu implements MenuInterface
{

    public function create(EntityManagerInterface $em): void
    {
        $mailSearch = new MenuItem();
        $mailSearch
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Log Search')
            ->setRoute('mail_search')
            ->setTag($this->tag());

        $em->persist($mailSearch);

        $mailDomain = new MenuItem();
        $mailDomain
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Edit Domain')
            ->setRoute('mail_domain')
            ->setTag($this->tag());

        $em->persist($mailDomain);

        $mailAcl = new MenuItem();
        $mailAcl
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Edit ACL')
            ->setRoute('mail_acl')
            ->setTag($this->tag());

        $em->persist($mailAcl);

        $mail = new MenuItem();
        $mail
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Mail')
            ->setUri('#')
            ->addChild($mailSearch)
            ->addChild($mailDomain)
            ->addChild($mailAcl)
            ->setTag($this->tag());

        $em->persist($mail);
    }

    public function order(): int
    {
        return 15;
    }

    public function tag(): string
    {
        return MenuInterface::DEFAULT_TAG;
    }
}