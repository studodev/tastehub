<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Studodev\FormUtilBundle\Validator\NotDisposableEmail as AssertNotDisposableEmail;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\UniqueConstraint(name: 'UNIQ_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: 'email', message: 'Cette adresse email est déjà associée à un compte')]
#[UniqueEntity(fields: 'username', message: 'Ce nom d\'utilisateur est déjà associée à un compte')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(
        message: 'Vous devez saisir une adresse email',
    )]
    #[Assert\Email(
        message: 'Cette adresse email n\'est pas valide',
    )]
    #[AssertNotDisposableEmail([
        'message' => 'Les adresses email jetables ne sont pas acceptées',
    ])]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[Assert\NotBlank(
        message: 'Vous devez choisir un nom d\'utilisateur',
    )]
    #[Assert\Length(
        min: 3,
        max: 30,
        minMessage: 'Votre nom d\'utilisateur doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'Votre nom d\'utilisateur doit contenir au maximum {{ limit }} caractères',
    )]
    #[ORM\Column(length: 30)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(
        message: 'Vous devez choisir un mot de passe',
    )]
    #[Assert\Length(
        min: 8,
        max: 50,
        minMessage: 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'Votre mot de passe doit contenir au maximum {{ limit }} caractères',
    )]
    #[Assert\NotCompromisedPassword(
        message: 'Ce mot de passe a fait l\'objet d\'une fuite de données publique, veuillez en choisir un autre',
    )]
    private ?string $plainPassword = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function eraseCredentials(): void
    {
         $this->plainPassword = null;
    }
}
