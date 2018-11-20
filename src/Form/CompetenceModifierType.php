<?php

namespace App\Form;

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

class CompetenceModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('code', TextType::class, array('label' => 'Code de la competence', 'disabled'=> true))
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier competence'))
            ;
    }

    public function getParent(){
      return CompetenceType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Competence::class,
        ]);
    }
}
