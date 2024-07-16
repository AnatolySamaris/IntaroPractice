<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3
                    ]),
                    new NotBlank([
                        'message' => 'Введите имя'
                    ]),
                ],
            ])
            ->add('lastName', TextType::class, [
                //'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3
                    ]),
                    new NotBlank([
                        'message' => 'Введите фамилию'
                    ]),
                ],
            ])
            ->add('patronymic', TextType::class, [
                //'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3
                    ]),
                    new NotBlank([
                        'message' => 'Введите отчество'
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/'
                    ]),
                ],
            ])
            ->add('phone', TelType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3
                    ]),
                    new Regex([
                        'pattern'=> "/^\+79\d{9}$/"
                    ]),
                    new NotBlank([
                        'message' => 'Введите номер телефона в формате +7XXXXXXXXXX',
                    ]),
                ],
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ],
            ])
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'Женский' => 2,
                    'Мужской' => 1,
                ],
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3
                    ]),
                    new NotBlank([
                        'message' => 'Введите адрес доставки'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'allow_extra_fields' => true,
            'csrf_protection' => false,
            // Configure your form options here
        ]);
    }
}
