<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EtudiantModifierType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('nom', TextType::class, array('label' => 'Nom de l\'étudiant', 'disabled'=> true))
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier étudiant'))
            ;
    }

    public function getParent(){
      return EtudiantType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
