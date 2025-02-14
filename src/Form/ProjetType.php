<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('employes', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => function (Employe $employe) {
                    return $employe->getPrenom() . ' ' . $employe->getNom();
                },
                'multiple' => true,
                'expanded' => false,

            ])
            ->add('archive')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
