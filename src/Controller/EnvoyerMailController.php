<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnvoyerMailController extends AbstractController
{
    // /**
    //  * @Route("/admin/envoieMail", name="us_envoieMail")
    //  */
    // public function sendEmail(\Swift_Mailer $mailer): Response
    // {
    //     // On crée le message
    //     $message = (new \Swift_Message('Invitation'))
    //         // On attribue l'expéditeur
    //         ->setFrom('univ.share.bayonne@gmail.com')
    //         // On attribue le destinataire
    //         ->setTo('univ.share.bayonne@gmail.com')
    //         // On crée le texte avec la vue
    //         ->setBody($this->renderView('registration/activation.html.twig'),'text/html');
    //     $mailer->send($message);

    //     $this->addFlash('message', 'Invitation envoyé.'); // Permet un message flash de renvoi
    //     return $this->redirectToRoute('us_confirmEnvoie');
    // }
    /**
     * @Route("/admin/envoieMail", name="us_envoieMail")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())->from('univ.share@laposte.net')
                                              ->to('univ.share@laposte.net')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Time for Symfony Mailer!')
        ->text('Sending emails is fun again!')
        ->html('<p>See Twig integration for better HTML integration!</p>');

        try {$mailer->send($email);} 
        catch (TransportExceptionInterface $e) {dump($e);}

        $this->addFlash('message', 'Invitation envoyé.'); // Permet un message flash de renvoi
        return $this->redirectToRoute('us_confirmEnvoie');
    }


    /**
     * @Route("/admin/confirmationEnvoie", name="us_confirmEnvoie")
     */
    public function confirmationEnvoie(): Response
    {
        return $this->render('admin/confirmationMail.html.twig');
    }


    /**
     * @Route("/passage-vers-inscription", name="us_passageInscription")
     */
    public function Activation(): Response
    {
        return $this->render('/registration/activation.html.twig');
    }

}
