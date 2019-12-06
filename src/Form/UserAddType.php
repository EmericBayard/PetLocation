<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                'label' => 'Firstname',
                'attr' => [
                ]

            ])
            ->add('lastname', TextType::class, [
                'required' => false,
                'label' => 'Lastname',
                'attr' => [
                ]

            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => 'email',
                'attr' => [
                  'placeholder' => 'Email...'
                ]

            ])
            ->add('password', TextType::class, [
                'required' => false,
                'label' => 'password',
                'attr' => [
                ]

            ])
            ->add('street', TextType::class, [
                'required' => false,
                'label' => 'street',
                'attr' => [
                ]

            ])
            ->add('zip', TextType::class, [
                'required' => false,
                'label' => 'zip',
                'attr' => [
                ]

            ])
            ->add('city', TextType::class, [
                'required' => false,
                'label' => 'city',
                'attr' => [
                ]

            ])
            ->add('country', TextType::class, [
                'required' => false,
                'label' => 'country',
                'attr' => [
                ]

            ])
            ->add('birthday', DateType::class, [
                'required' => false,
                'label' => 'birthday',
                'attr' => [
                  'class' => 'js-datepicker'
                ]

            ])
            ->add('sexe', TextType::class, [
                'required' => false,
                'label' => 'sexe',
                'attr' => [
                ]

            ])
            ->add('active', TextType::class, [
                'required' => false,
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