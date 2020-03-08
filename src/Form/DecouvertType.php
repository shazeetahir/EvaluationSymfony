<?php

namespace App\Form;

use App\Entity\Continent;
use App\Entity\Decouvert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use App\EventSubscriber\Form\ProductFormSubscriber;
use App\EventSubscriber\Form\DecouvertFormSubscriber;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\EventSubscriber\Entity\DecouvertEventSubscriber;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DecouvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            		    'message' => "Le description est obligatoire"
		            ])
	            ]
            ])
            ->add('description', TextareaType::class, [
	            'constraints' => [
		            new NotBlank([
                         'message' => "La description est obligatoire"
                     ])
                ]
            ])
            

            ->add('continent', EntityType::class, [
                'class' => Continent::class,
                'choice_label' => 'name',
                'placeholder' => '',
                'constraints' => [
                    new NotBlank([
			            'message' => "Le categorie est obligatoire"
		            ]),
                ]
            ])
		;          
		$builder->addEventSubscriber(new DecouvertFormSubscriber());

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Decouvert::class,
        ]);
    }
}
