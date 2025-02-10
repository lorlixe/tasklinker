<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Tache;
use App\Entity\Projet;
use App\Enum\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('dealine', null, [
                'widget' => 'single_text'
            ])
            ->add('statut', EnumType::class, [
                'class' => Statut::class,
            ])
            ->add('projet_id', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'id',
            ])
            ->add('employe', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => 'id',
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
