<?php

namespace App\Form;

use App\Entity\Trajet;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieuDepartTrajet',TextType::class,[
                'attr'=> ['class' =>'form-control'],
                'label'=>'Address de départ'])
            ->add('lieuArriveeTrajet', TextType::class,[
                'attr'=> ['class' =>'form-control'],
                'label'=>'Address d'.'arrivée'])
            ->add('detourMaxTrajet', TextType::class,[
                'attr'=> ['class' =>'form-control'],
                'label'=>'Detour Max'])
            ->add('dateDepart',DateTimeType::class,[
                'label'=>'Date de départ'])
            ->add('formatObjet',ChoiceType::class, array(
        'choices' => array(
            'XS'=>'XS',
            'S'=>'S',
            'L'=> 'L',
            'XL'=> 'XL',
            'XXL'=> 'XXL',
        ),
                'label'=>'Format d \'objets'

    ))
            ->getForm()

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
