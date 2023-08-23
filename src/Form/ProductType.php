<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],

                'label' => 'Name',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])

            ->add(
                'Description',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],

                    'label' => 'Description',
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                    ]
                ]
            )
            ->add(
                'PBT',
                MoneyType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],

                    'currency' => 'TWD',
                    'label' => 'Price',
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                    ],
                    'constraints' => [
                        new Assert\Positive(),
                        new Assert\LessThan(9999.99),
                    ]
                ]
            )
            ->add('visible',  CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label' => 'Visible',
                'label_attr' => [
                    'class' => 'form-check-label',
                ],
                'required' => false,
            ])

            ->add('OnSale', CheckboxType::class, [
                'label' => 'On Sale',
                'required' => false, // 如果不是必填，可以設為 false
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
                // 'constraints' => [
                //     new Assert\IsTrue(),
                // ],
            ])


            // ->add('dateCreated', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'data' => new \DateTimeImmutable('now'),
            //     'label_attr' => [
            //         'class' => 'form-label mt-4',
            //     ],
            //     'constraints' => [
            //         new Assert\NotNull(),
            //     ]
            // ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'Title',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Category',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                ]
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Create Product',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
