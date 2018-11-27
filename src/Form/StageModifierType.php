<?php

namespace App\Form;
use App\Entity\Etudiant;
use App\Entity\Maison;
use App\Entity\Note;
use App\Entity\Competence;
use App\Entity\Professeur;
use App\Entity\Tuteur;
use App\Entity\Entreprise;
use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StageModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('dateDebut', TextType::class, array('label' => 'Date de début', 'disabled'=> true))
            //->add('dateFin', TextType::class, array('label' => 'Date de fin', 'disabled'=> true))
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier stage'))
        ;
    }
	
	public function getParent(){
      return StageType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
