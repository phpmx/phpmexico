<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Twig\Environment;
use Swift_Mailer;
use Swift_Message;
use \Twig\Error\LoaderError;
use \Twig\Error\RuntimeError;
use \Twig\Error\SyntaxError;

class SendLoginEmail implements EventSubscriber
{
    /** @var Swift_Mailer $mailer */
    protected $mailer;

    /** @var Environment $twig */
    protected $twig;

    /**
     * SendLoginEmail constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
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

    /**
     * @param LifecycleEventArgs $args
     */
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

    /**
     * @param LifecycleEventArgs $args
     * @return User
     */
    private function login(LifecycleEventArgs $args): User
    {
        /** @var User $user */
        $user = $args->getObject();

        $em = $args->getObjectManager();

        $hash = hash('gost', $user->getEmail().date('Y-m-d H:i:s'));
        $user->setLoginToken($hash);

        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @param User $user
     * @param string $template
     * @return Swift_Message
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function message(User $user, string $template): Swift_Message
    {
        $login_url = 'https://phpmexico.mx/?token='.$user->getLoginToken();

        return (new Swift_Message('PHP México'))
            ->setFrom(['no-replay@phpmexico.mx' => 'David de PHP México'])
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render('emails/'.$template, [
                    'login_url' => $login_url,
                    'username' => $user->getUsername(),
                ]),
                'text/html'
            );
    }
}
