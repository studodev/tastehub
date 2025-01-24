<?php

namespace App\Entity\Cooking;

use App\Repository\Cooking\StepRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    public const DESCRIPTION_MAX_LENGTH = 500;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(
        message: 'Veuillez saisir une description',
    )]
    #[Assert\Length(
        max: self::DESCRIPTION_MAX_LENGTH,
        maxMessage: 'La description doit contenir au maximum {{ limit }} caractères',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $number = 0;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    /**
     * @var Collection<int, StepRecipeIngredient>
     */
    #[ORM\OneToMany(targetEntity: StepRecipeIngredient::class, mappedBy: 'step', orphanRemoval: true)]
    private Collection $stepRecipeIngredients;

    public function __construct()
    {
        $this->stepRecipeIngredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return Collection<int, StepRecipeIngredient>
     */
    public function getStepRecipeIngredients(): Collection
    {
        return $this->stepRecipeIngredients;
    }

    public function addStepRecipeIngredient(StepRecipeIngredient $stepRecipeIngredient): static
    {
        if (!$this->stepRecipeIngredients->contains($stepRecipeIngredient)) {
            $this->stepRecipeIngredients->add($stepRecipeIngredient);
            $stepRecipeIngredient->setStep($this);
        }

        return $this;
    }

    public function removeStepRecipeIngredient(StepRecipeIngredient $stepRecipeIngredient): static
    {
        if ($this->stepRecipeIngredients->removeElement($stepRecipeIngredient)) {
            if ($stepRecipeIngredient->getStep() === $this) {
                $stepRecipeIngredient->setStep(null);
            }
        }

        return $this;
    }
}
