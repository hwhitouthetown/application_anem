<?php
namespace AppBundle\Service;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\SwiftmailerBundle\Swift_Message;
use AppBundle\Entity\User;

class Mailer extends Controller
{
protected $mailer;


public function __construct($mailer)
{
$this->mailer = $mailer;
}


public function sendMessageRegister(User $user){

 $message = \Swift_Message::newInstance()
    ->setSubject('Objet de l\'email')
    ->setFrom('donotreply@anem.com')
    ->setReplyTo('anemnantes@gmail.com')
    ->setTo($user->getEmail())
    ->setContentType('text/html')
    ->setBody('Chèr(e)'. $user->getNom() .'ton compte a bien été crée, il sera actif dès lors que les administrateurs auront validé ton inscription, tu receveras une confirmation d\'activation à cet e-mail');

    $response = $this->mailer->send($message);
 
	if (! $response ) {
    	throw new Exception('Le mail n\'a pas pu être envoyé');
	}

    return $response;

}



}

