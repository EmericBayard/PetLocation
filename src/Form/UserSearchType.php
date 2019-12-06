<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Petdb\UserSearch;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                  'placeholder' => 'Email...'
                ]

            ])
            ->add('dateCreatedAt', DateType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                  'placeholder' => 'By createdAt date'
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    // Eviter l'utilisation des valeurs par défaut dans l'url...
    public function getBlockPrefix()
    {
        return '';
    }
}

?>