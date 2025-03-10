<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Tache;
use App\Entity\Projet;
use App\Enum\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de la tâche',
                'empty_data' => '',

            ])

            ->add('description')

            ->add('deadline', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_data' => null

            ])
            ->add('statut', EnumType::class, [
                'class' => Statut::class,
                'choices' => Statut::cases(),
                'choice_label' => fn(Statut $statut) => $statut->name,

            ])
            // ->add('projet', EntityType::class, [
            //     'class' => Projet::class,
            //     'choice_label' => 'nom',
            //     'placeholder' => 'Sélectionner un projet',
            // ])
            ->add('employes', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => function (Employe $employe) {
                    return $employe->getPrenom() . ' ' . $employe->getNom();
                },
                'multiple' => true,
                'expanded' => false,
                'label' => 'Membre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
