<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Petdb\UserSearch;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Petdb\User;

class UserAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'Firstname',
                'attr' => [
                ]

            ])
            ->add('lastname', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'Lastname',
                'attr' => [
                ]

            ])
            ->add('email', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'email',
                'attr' => [
                  'placeholder' => 'Email...'
                ]

            ])
            ->add('password', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'password',
                'attr' => [
                ]

            ])
            ->add('street', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'street',
                'attr' => [
                ]

            ])
            ->add('zip', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'zip',
                'attr' => [
                ]

            ])
            ->add('city', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'city',
                'attr' => [
                ]

            ])
            ->add('country', TextType::class, [
                'required' => false,
                'empty_data' => '',
                'label' => 'country',
                'attr' => [
                ]

            ])
            ->add('birthday', DateType::class, [
                'required' => false,
                'empty_data' => null,
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'birthday',
                'attr' => [
                  'class' => 'js-datepicker'
                ]

            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                  'Homme' => 'Homme',
                  'Femme' => 'Femme'
                ],
                'label' => 'sexe',
                'attr' => [
                ]

            ])
            ->add('active', ChoiceType::class, [
                'choices' => [
                  'Actif' => true,
                  'Inactif' => false
                ],
                'label' => 'active',
                'attr' => [
                ]

            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    // Eviter l'utilisation des valeurs par défaut dans l'url...
    // public function getBlockPrefix()
    // {
    //     return '';
    // }
}

?>