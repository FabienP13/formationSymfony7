<?php

namespace App\Form;

use App\Enum\FlightClass;
use App\Enum\SeatReference;
use App\Enum\TransportType;
use App\Model\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('transportType', EnumType::class, [
                'class' => TransportType::class,
                'label' => 'Type de transport',
                'placeholder' => 'Sélectionnez un type de transport',
            ])
            ->add('isRoundTrip', CheckboxType::class, [
                'label' => 'Aller-retour',
                'required' => false,
            ])
            ->add('departureDate', DateType::class, [
                'label' => 'Date de départ',
            ]);

        $builder->addDependent('returnDate', 'isRoundTrip', function (DependentField $field, bool $isRoundTrip) {
            if ($isRoundTrip) {
                $field->add(DateType::class, [
                    'label' => 'Date de retour',
                ]);
            }
        });
        $builder->addDependent('flightClass', 'transportType', function (DependentField $field, ?TransportType $transportType) {
            if ($transportType === TransportType::PLANE) {
                $field->add(EnumType::class, [
                    'class' => FlightClass::class,
                    'label' => 'Classe',
                    'placeholder' => 'Sélectionnez une classe',
                ]);
            }
        });
        $builder->addDependent('seatReference', 'transportType', function (DependentField $field, ?TransportType $transportType) {

            if (!$transportType) {
                return;
            }

            $isPlane = $transportType === TransportType::PLANE;
            $field->add(EnumType::class, [
                'class' => SeatReference::class,
                'label' => 'Préférence de siège',
                'choices' => $isPlane ? SeatReference::plane() : SeatReference::train(),
                'placeholder' => 'Sélectionnez une préférence de siège',
            ]);
        });

        $builder->add('submit', SubmitType::class, [
            'label' => 'Réserver',
            'priority' => -1
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
