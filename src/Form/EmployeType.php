<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Projet;
use App\Enum\Contrat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'empty_data' => '',
            ])
            ->add('prenom', TextType::class, [
                'empty_data' => '',
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'empty_data' => '',
            ])
            ->add('contrat', EnumType::class, [
                'class' => Contrat::class,
            ])
            ->add('date_arrivee', null, [
                'widget' => 'single_text',
                'empty_data' => null,

            ])
            // ->add('projets', EntityType::class, [
            //     'class' => Projet::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
