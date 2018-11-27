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

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateTimeType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text',
                                                          'format' => 'dd/MM/yyyy',
                                                          'required' => true,
                                                          'label' =>'Date de début',
                                                          'placeholder' => 'jj/mm/aaaa'))
            ->add('dateFin', DateTimeType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text',
                                                          'format' => 'dd/MM/yyyy',
                                                          'required' => true,
                                                          'label' =>'Date de fin',
                                                          'placeholder' => 'jj/mm/aaaa'))
            ->add('objet', TextType::class)
            ->add('entreprise', EntityType::class, array('class' => 'App\Entity\Entreprise','choice_label' => 'nom' ))
            ->add('tuteur', EntityType::class, array('class' => 'App\Entity\Tuteur','choice_label' => 'nom' ))
            ->add('etudiant', EntityType::class, array('class' => 'App\Entity\Etudiant','choice_label' => 'nom' ))
            ->add('competences', EntityType::class, array('class' => 'App\Entity\Competence',
														'choice_label' => 'libelle' ,
														'expanded' => true,
														'multiple'=> true))
			->add('enregistrer', SubmitType::class, array('label' => 'Nouveau stage'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
