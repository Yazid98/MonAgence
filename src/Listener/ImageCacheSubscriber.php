<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{
    private $cacheManager;

    private $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate',
        ];
    }

    public function preRemove(PreFlushEventArgs $args)
    {
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
    }
}
