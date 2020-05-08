<?php

namespace App\EventListener;

use App\Entity\Contact;
use App\Entity\Job;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Twig\Environment;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;

class SendContactEmail implements EventSubscriber
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
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        /** @var Contact $user */
        $contact = $args->getObject();

        if (!$contact instanceof Contact) {
            return;
        }

        $this->mailer
            ->send($this->message(
                $contact->getDeveloper()->getEmail(),
                $contact->getUser()->getEmail(),
                $contact->getJob()
            ));
    }

    public function message(string $email, string $replay, Job $job)
    {
        return (new \Swift_Message('Te han enviado una propuesta de trabajo en PHP México'))
            ->setFrom(['no-replay@phpmexico.mx' => 'David Flores de PHPMx'])
            ->setTo($email)
            ->setReplyTo($replay)
            ->setBody(
                $this->twig->render('emails/contact.html.twig', [
                    'description' => $job->getDescription(),
                ]),
                'text/html'
            );
    }
}
