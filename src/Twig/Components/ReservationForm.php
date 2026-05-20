<?php   

namespace App\Twig\Components;

use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class ReservationForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    protected function instantiateForm(): FormInterface
    {
        // Provide a default empty form. Replace with your actual form configuration.
        return $this->createForm(ReservationType::class);
    }

    #[LiveAction]
    public function save(): void {
        $this->submitForm();
        $reservation = $this->form->getData();

        dd($reservation);
    }
}