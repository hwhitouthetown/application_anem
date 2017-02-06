<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class StageFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', Filters\TextFilterType::class)
            ->add('description', Filters\TextFilterType::class)
            ->add('etat', Filters\TextFilterType::class)
            ->add('id', Filters\NumberFilterType::class)
        
            ->add('identreprise', Filters\EntityFilterType::class, array(
                    'class' => 'AppBundle\Entity\Entreprise',
                    'choice_label' => 'id',
            )) 
            ->add('idetudiant', Filters\EntityFilterType::class, array(
                    'class' => 'AppBundle\Entity\User',
                    'choice_label' => 'id',
            )) 
            ->add('competences', Filters\EntityFilterType::class, array(
                    'class' => 'AppBundle\Entity\Competence',
                    'choice_label' => 'id',
            )) 
        ;
        $builder->setMethod("GET");


    }

    public function getBlockPrefix()
    {
        return null;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
