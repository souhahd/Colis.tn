<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreArticle',TextType::class,[
                'attr'=> ['class' =>'form-control'],
                'label'=>'Titre'])
            ->add('contenuArticle',TextType::class,['attr'=> ['class' =>'form-control'],
                'label'=>'Contenu'])
            ->add('datePubArticle',DateTimeType::class,[
        'label'=>'Date de publication'])
            ->add('auteurArticle',TextType::class,['attr'=> ['class' =>'form-control'],
                'label'=>'Auteur'])
            ->add('sourceArticle',TextType::class,['attr'=> ['class' =>'form-control'],
                'label'=>'Source'])
            ->add('imageFile', VichImageType::class, [
                'label'=>'Image(JPG ou PNG)',
                'required' => false,
                'allow_delete' => false,
                'delete_label' => 'Effacer',
                'download_label' => 'Télécharger',
                'download_uri' => true,
                'imagine_pattern' => 'squared_thumbnail_small'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
