<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Twig\Environment;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;

class SendLoginEmail implements EventSubscriber
{
    protected $mailer;

    protected $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $user = $args->getObject();
        if (!$user instanceof User) {
            return;
        }

        $changeArray = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($args->getObject());
        if (array_key_exists('last_login', $changeArray)) {
            $user = $this->login($args);
            $this->mailer
                ->send($this->message($user, 'login.html.twig'));
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $isUser = $args->getObject();
        if (!$isUser instanceof User) {
            return;
        }

        $user = $this->login($args);
        $this->mailer
            ->send($this->message(
                $user,
                'welcome.html.twig'
            ));
    }

    private function login(LifecycleEventArgs $args)
    {
        /** @var User $user */
        $user = $args->getObject();

        $em = $args->getObjectManager();

        $hash = hash('gost', $user->getEmail() . date('Y-m-d H:i:s'));
        $user->setLoginToken($hash);

        $em->persist($user);
        $em->flush();

        return $user;
    }

    private function message(User $user, string $template)
    {
        $login_url = 'https://phpmexico.mx/?token=' . $user->getLoginToken();

        return (new \Swift_Message('PHP México'))
            ->setFrom(['no-replay@phpmexico.mx' => 'David de PHP México'])
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render('emails/' . $template, [
                    'login_url' => $login_url,
                    'username' => $user->getUsername(),
                ]),
                'text/html'
            );
    }
}
