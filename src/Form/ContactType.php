<?php

namespace App\Form;

use App\Form\Model\ContactFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	/*
    	 * étapes de création d'un formulaire
    	 *   - optionnel : création d'un modèle
    	 *       chaque propriété du modèle est associé à un champ de saisie
    	 *       créer un getter/setter pour chaque propriété
    	 *   - créer la classe de formulaire
    	 *      commande : symfony console make:form
    	 *      relier le modèle à la classe de formulaire : méthode configureOptions
    	 *      dans la méthode buildForm : utiliser la méthode add pour ajouter un champ de saisie
    	 *  - dans un contrôleur, créer le formulaire et l'envoyer à la vue
    	 *  - dans la vue, afficher les champs de saisie
    	 *  - dans le contrôleur, gérer la soumission du formulaire
    	 */

    	//dd($options['data']);

	    /*
    	 * add permet d'ajouter des champs à la classe de formulaire
    	 *    - nom du champ de saisie récupéré dans la vue du formulaire
    	 *    - type du champ
    	 *    - options du champ de saisie
    	 *       - constraints: contraintes de validation
    	 * le paramètre options permet de récupérer des informations du modèle relié à la classe de formulaire
    	 * il est recommandé d'utiliser le nom des propriétés du modèle pour le nom des champs
    	 */
        $builder
            ->add('firstname', TextType::class, [
				'constraints' => [
					new NotBlank([
						'message' => "Le prénom est obligatoire"
					]),
					new Length([
						'min' => 2,
						'max' => 25,
						'minMessage' => "Votre prénom doit contenir {{ limit }} caractères au minimum",
						'maxMessage' => "Votre prénom doit contenir {{ limit }} caractères au maximum"
					])
				]
            ])
            ->add('lastname', TextType::class, [
	            'constraints' => [
		            new NotBlank([
                         'message' => "Le nom est obligatoire"
                     ]),
		            new Length([
	                       'min' => 2,
	                       'max' => 50,
	                       'minMessage' => "Votre nom doit contenir {{ limit }} caractères au minimum",
	                       'maxMessage' => "Votre nom doit contenir {{ limit }} caractères au maximum"
                       ])
	            ]
            ])
            ->add('email', EmailType::class, [
            	'constraints' => [
            		new NotBlank([
            		    'message' => "L'email est obligatoire"
            		]),
		            new Email([
		            	'message' => "L'email est incorrect"
		            ])
	            ]
            ])
            ->add('message', TextareaType::class, [
	            'constraints' => [
		            new NotBlank([
                         'message' => "Le message est obligatoire"
                    ])
		            // new Length([
		            // 	'min' => 10,
	                //     'minMessage' => "Votre message doit contenir {{ limit }} caractères au minimum"
                    // ])
	            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    	/*
    	 * data_class : permet de relier la classe de formulaire à un modèle
    	 * la constante ::class renvoie l'espace de noms d'une classe PHP
    	 */
        $resolver->setDefaults([
            'data_class' => ContactFormModel::class
        ]);
    }
}