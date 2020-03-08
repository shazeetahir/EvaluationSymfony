<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\Model\ContactFormModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact.index")
     */
    public function index(Request $request, MailerInterface $mailer):Response
    {
        /**
		 * recuperer les infos de l'utilisateur : $this->getUser()
		 * tester le role de user : $this->isGranted()
		 * denyAccessUnlessGranted : access refusé
		 */
		//$this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
		//dd($this->getUser());



		/*
		 * affichage d'un formulaire
		 *   se base
		 *      - sur l'espace de noms de la classe de formulaire
		 *      - sur une instance du modèle relié à la classe de formulaire
		 *  handleRequest permet de récupérer la saisie dans la requête HTTP
		 *  createView permet d'envoyer le formulaire sous forme de vue
		 */
		$type = ContactType::class;
		$model = new ContactFormModel();
		$form = $this->createForm($type, $model);
		$form->handleRequest($request);

		// si le formulaire est valide
		if($form->isSubmitted() && $form->isValid()){
			//dd($model);
			/*
			 * envoi d'un email
			 *   service d'envoi d'email dans symfony : MailerInterface
			 * types d'email:
			 *   Email: permet d'écrire le contenu de l'email directement dans la classe
			 *   TemplatedEmail: permet d'écrire le contenu de l'email dans des templates twig
			 */
			$message = (new TemplatedEmail())
				->from( $model->getEmail() ) // expéditeur
				->to('4fac0ec5a7-6da8bd@inbox.mailtrap.io') // destinataire
				->subject('Contact') // sujet de l'email
				->textTemplate('emailing/contact.txt.twig') // cibler un template twig au format txt
				->context([
					'firstname' => $model->getFirstname(),
					'lastname' => $model->getLastname(),
					'message' => $model->getMessage(),
				]) // permet d'envoyer des variables au template
			;

			/*$message = (new Email())
				->from($model->getEmail()) // expéditeur
				->to(' 4fac0ec5a7-6da8bd@inbox.mailtrap.io') // destinataire
				->subject('Contact') // sujet de l'email
				->text("
					********** nom prénom ********** 
					{$model->getFirstname()} {$model->getLastname()}
					********** message ********** 
					{$model->getMessage()}
				")
				->html("
					<h3 style='color: tomato'>
						{$model->getFirstname()} {$model->getLastname()}
					</h3>
					<p>{$model->getMessage()}</p>
				")
			;*/
			$mailer->send($message);

			// message flash : message stocké en session et affiché une seule fois
			//$this->addFlash('notice', "Votre message a été envoyé");

			// redirection vers une route par son nom
			return $this->redirectToRoute('homepage.index');
		}

		return $this->render('contact/index.html.twig', [
			'form' => $form->createView()
		]);
    }
}
