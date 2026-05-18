<?php

namespace App\Form;

use App\DTO\ContactFormDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Translation\t;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => t('Nom'),
            ])
            ->add('email', EmailType::class, [
                'label' => t('Email'),
            ])
            ->add('message', TextareaType::class, [
                'label' => t('Message'),
            ])
            ->add('service', ChoiceType::class, [
                'choices'  => [
                    'Comptabilité' => 'compta@demo.fr',
                    'Support' => 'support@demo.fr',
                    'Marketing' => 'marketing@demo.fr',
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn-success']
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactFormDTO::class,
        ]);
    }
}
