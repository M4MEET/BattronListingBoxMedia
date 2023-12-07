<?php declare(strict_types=1);

namespace BattronListingBoxMedia;

use BattronListingBoxMedia\Subscriber\ManufacturerMediaSubscriber;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BattronListingBoxMedia extends Plugin
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->registerForAutoconfiguration(ManufacturerMediaSubscriber::class)
            ->addTag('kernel.event_subscriber');
    }
}
