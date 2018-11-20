<?php

namespace App\Form;

use App\Entity\Professeur;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProfesseurModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('nom', TextType::class, array('label' => 'Nom du professeur', 'disabled'=> true))
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier professeur'))
            ;
    }

    public function getParent(){
      return ProfesseurType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
