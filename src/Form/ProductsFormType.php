<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;



class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options:[
                'label' => 'Nom',
                'required' => false     
            ])
            ->add('description', options:[
                'label' => 'Description',
                'required' => false
            ])
            ->add('price', MoneyType::class, options:[
                'label' => 'Prix',
                'divisor' => 100,
                // 'constraints' => [
                //     new Positive(
                //         message
                //     )
                // ],
                'required' => false
            ])
            ->add('stock', options:[
                'label' => 'Quantité',
                'required' => false
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Categorie'
            ])
            ->add('image', FileType::class, [
                'data_class' => null,
                'label' => 'Image', 
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxWidth'=> 1280,
                        'maxWidthMessage' => 'L\'image doit faire 1280 pixels de large au maximum'
                    ])
                ]
            ])
        ;


        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
