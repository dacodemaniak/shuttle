<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("lastName")
            ->add("firstName")
            ->add(
                "email",
                EmailType::class
            )
            ->add(
                "wishedPlaces",
                ChoiceType::class,
                [
                    "choices" => $this->makeList()
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
            "data_class" => Customer::class
        ]);
    }
    
    private function makeList(): array {
        $choices = [];
        for ($i = 1; $i < 9; $i++) {
            $choices[$i] = $i;
        }
        return $choices;
    }
}
