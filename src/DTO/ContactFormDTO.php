<?php 

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactFormDTO
{
    #[Assert\NotBlank(message: "Le nom est requis.")]
    #[Assert\Length(min:3,max:50)]
    private ?string $nom = '';

    #[Assert\NotBlank(message: "L'email est requis.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    private ?string $email = '';

    #[Assert\NotBlank(message: "Le message est requis.")]
    #[Assert\Length(min:3,max:200)]
    private ?string $message = '';

    #[Assert\NotBlank(message: "Le service doit être sélectionné.")]
    private ?string $service = '';

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }
     public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): void
    {
        $this->service = $service;
    }
}