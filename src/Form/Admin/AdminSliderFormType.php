<?php

namespace App\Form\Admin;

use App\Entity\AdminSlider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminSliderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'data_class' => null,
                'label' => 'Image', 
                'required' => false,
                // 'constraints' => [
                //     new Image([
                //         'maxWidth'=> 1280,
                //         'maxWidthMessage' => 'L\'image doit faire 1280 pixels de large au maximum'
                //     ])
                // ]
            ])
            ->add('ordre', ChoiceType::class, [
                "choices"=>[
                    "1" => "1",
                    "2" => "2",
                    "3" => "3",      
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdminSlider::class,
        ]);
    }
}
