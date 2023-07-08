<?php


namespace App\EventSubscriber;


use Gedmo\Loggable\LoggableListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LoggerSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var LoggableListener
     */
    private $loggableListener;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        LoggableListener $loggableListener
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->loggableListener = $loggableListener;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    public function onKernelRequest()
    {
        if ($this->tokenStorage !== null &&
            $this->tokenStorage->getToken() !== null
        ) {
            $this->loggableListener->setUsername($this->tokenStorage->getToken()->getUser()->getUsername());
        }
    }

}
