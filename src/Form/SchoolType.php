<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn', TextType::class)
            ->add('name', TextType::class)
            ->add('abstract', TextType::class)
            ->add('enabled', CheckboxType::class, [
                'label' => 'on',
                 'label_attr' => ['class' => 'switch-custom'],
              ])
//            ->add('enabled', CheckboxType::class, [
//                ' label_attr' => ['class' => 'radio-inline'],switch-custom
//            ])
            
            ->add('numberOfPages', TextType::class)          
            ->add('datePabulished', DateTimeType::class)
            ->add('Submit', SubmitType::class, [
                'label' => 'Save changes',
                'attr' => [
                    'class' => 'btn btn-outline-primary float-right',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
