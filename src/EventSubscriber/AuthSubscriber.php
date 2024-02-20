<?php

namespace App\EventSubscriber;

use App\Controller\Auth\AuthFilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $requestEvent): void
    {
        if ($requestEvent->getRequest()->headers->get('Authorization') !== null) {
            preg_match('/Bearer\s(\S+)/', $requestEvent->getRequest()->headers->get('Authorization'), $matches);
            try {
                JWT::decode($matches[1], new Key('%env(APP_SECRET)%', 'HS256'));
            } catch (\Exception $exception) {
                die($exception->getMessage());
            }
        }else{
            die([
                'message'=>'Check your Authorization in headers.'
            ]);
        }
    }

    public function onKernelController(ControllerEvent $controllerEvent): void
    {
        $controller = $controllerEvent->getController();
        if (is_array($controller)) {
            $controllerObject = $controller[0];
        }
        if ($controllerObject instanceof AuthFilterInterface) {
            /**role permissions check control*/
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}
