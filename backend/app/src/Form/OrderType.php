<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class OrderType extends AbstractType
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
                ],
            ])
            ->add('patronymic', TextType::class, [
                //'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/'
                    ]),
                    new NotBlank([
                        'message' => 'Введите адрес доставки'
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
            ->add('deliveryType', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Самовывоз' => 'self-delivery',
                    'Почта России' => 'russian-post',
                    'EMS Почта России' => 'ems',
                    'Доставка курьером' => 'courier',
                    'СДЭК v.2' => 'sdek-v-2' 
                ]
            ])
            ->add('paymentType', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Наличными' => 'cash',
                    'Банковской картой' => 'bank-card',
                    'Банковский перевод' => 'bank-transfer',
                    'eMoney' => 'e-money',
                    'В рассрочку' => 'credit'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            // Configure your form options here
        ]);
    }
}
