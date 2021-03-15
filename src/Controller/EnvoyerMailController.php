<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnvoyerMailController extends AbstractController
{
    /**
     * @Route("/admin/envoyerMail", name="us_envoyerMail")
     */
    public function sendEmail(Request $request,\Swift_Mailer $mailer): Response
    {
            // On crée le message
            $message = (new \Swift_Message('Invitation'))
                // On attribue l'expéditeur
                ->setFrom('univ.share.bayonne@gmail.com')
                // On attribue le destinataire
                ->setTo('eblandin002@iutbayonne.univ-pau.fr')
                // On crée le texte avec la vue
                ->setBody($this->renderView('emails/activation.html.twig'),'text/html');
            $mailer->send($message);

            $this->addFlash('message', 'Invitation envoyé.'); // Permet un message flash de renvoi
        }
        return $this->render('/admin');
    }

}
