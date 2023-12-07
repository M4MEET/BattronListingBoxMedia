<?php

namespace BattronListingBoxMedia\Subscriber;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ManufacturerMediaSubscriber implements EventSubscriberInterface
{
    private $manufacturerRepository;

    public function __construct(EntityRepository $manufacturerRepository)
    {
        $this->manufacturerRepository = $manufacturerRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'product.loaded' => 'onProductsLoaded'
        ];
    }

    public function onProductsLoaded(EntityLoadedEvent $event): void
    {
        foreach ($event->getEntities() as $product) {
            $manufacturerId = $product->getManufacturerId();
            if (!$manufacturerId) {
                continue;
            }

            $criteria = new Criteria([$manufacturerId]);
            $criteria->addAssociation('media');
            $manufacturer = $this->manufacturerRepository->search($criteria, $event->getContext())->first();

            if ($manufacturer && $manufacturer->getMedia()) {
                $product->addExtension('manufacturerMedia', $manufacturer->getMedia());
            }
        }
    }
}
