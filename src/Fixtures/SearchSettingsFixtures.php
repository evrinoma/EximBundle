<?php

namespace Evrinoma\EximBundle\Fixtures;


use Evrinoma\EximBundle\Std\FileStd;
use Evrinoma\EximBundle\Dto\LogSearchDto;
use Evrinoma\SettingsBundle\Entity\Settings;

/**
 * Class SearchSettingsFixtures
 *
 * @package Evrinoma\EximBundle\DataFixtures
 */
class SearchSettingsFixtures extends AbstractEximFixtures
{

//region SECTION: Fields
    private $files = [
        'main.log'     => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.1'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.2'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.3'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.4'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.5'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.6'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.7'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.8'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.9'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.10'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.11'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.12'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.13'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.14'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.15'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.1' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.2' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.3' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.4' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.5' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.6' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.7' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.8'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.9'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.10'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.11'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.12'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.13'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.14'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.15'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log'    => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.1'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.2'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.3'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.4'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.5'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.6'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.7'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.8'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log.9'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log.10'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log.11'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log.12'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log.13'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log.14'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log.15'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log'    => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.1'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.2'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.3'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.4'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.5'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.6'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.7'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.8'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.9'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.10'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.11'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.12'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.13'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.14'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.15'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
//        'greylist_dbg.7'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.6'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.5'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.4'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.3'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.2'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.1'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.log' => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
    ];
//endregion Fields
//region SECTION: Public

    public function create()
    {
        $repository = $this->objectManager->getRepository(Settings::class);

        foreach ($this->files as $name => $filePath) {
            $file = new FileStd();

            $settingFile = new Settings();
            $settingFile
                ->setData($file->setName($name)->setPath($filePath))
                ->setType(LogSearchDto::class);

            $this->objectManager->persist($settingFile);
        }
    }

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return ['EximFixtures', 'SearchSettingsFixtures'];
    }
//endregion Getters/Setters
}