<?php

namespace App\EventSubscriber\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DecouvertFormSubscriber implements EventSubscriberInterface{
    public static function getSubscribedEvents(){

        /**
         * evenement de formulaire
         * PRE_SET_DATA : avant l'initialisation du formulaire, les donnees du formulaire ne sont relies a un modele
         * POST_SET_DATA : avant l'initialisation du formulaire, les donnees du formulaire sont relies a un modele
         * PRE_SUBMIT : avant la soumission
         * SUBMIT : lors de la soumission
         * POST_SUBMIT : Apres la soumission
         */

        return[
            FormEvents::POST_SET_DATA => 'postSetData'
        ];
    }

    public function postSetData(FormEvent $event):void
    {

        /**
         * getData : donnees initiales du formulaire avant la soumission
         * getForm : classe de formulaire
         */

         $data = $event->getData();
         $form = $event->getForm();
         $model = $form->getData();


         //ajout de champ image
         $form->add('image', FileType::class, [
            'data_class' => null, //permet d'indiquer qu'aucune classe ne va contenir les propriétés d'une image transférée
            'constraints' => $data->getId() ? [] : [
                new NotBlank([
                     'message' => "L'image est obligatoire"
                ]),
                new Image([
                    'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
                    'mimeTypesMessage' => "L'image n'est pas dans un format Web"
                ])
            ]
        ]);

        //dd($data, $form, $model);
    }

}
