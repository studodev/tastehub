<?php

namespace App\Entity\Cooking;

use App\Enum\Cooking\DraftRecipeStatusEnum;
use App\Model\Cooking\QuantityCounter;
use App\Model\Cooking\RecipeTimer;
use App\Repository\Cooking\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Dunglas\DoctrineJsonOdm\Type\JsonDocumentType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    public const DESCRIPTION_MAX_LENGTH = 350;
    public const MAX_TAGS = 10;
    public const MIN_INGREDIENTS = 2;
    public const MAX_INGREDIENTS = 100;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(
        message: 'Veuillez saisir un titre',
    )]
    #[Assert\Length(
        min: 5,
        max: 60,
        minMessage: 'Le titre doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'Le titre doit contenir au maximum {{ limit }} caractères',
    )]
    #[ORM\Column(length: 60)]
    private ?string $title = null;

    #[Assert\Length(
        max: self::DESCRIPTION_MAX_LENGTH,
        maxMessage: 'La description doit contenir au maximum {{ limit }} caractères',
    )]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[Assert\Expression(
        expression: 'this.getPicture() or this.getPictureFile()',
        message: 'Veuillez choisir une image',
    )]
    #[Assert\File(
        maxSize: '10M',
        extensions: ['jpeg', 'jpg'],
    )]
    private ?UploadedFile $pictureFile = null;

    #[Assert\Valid(
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    #[ORM\Column(type: JsonDocumentType::NAME)]
    private RecipeTimer $timer;

    #[Assert\Valid(
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    #[ORM\Column(type: JsonDocumentType::NAME)]
    private QuantityCounter $quantityCounter;

    #[Assert\NotBlank(
        message: 'Veuillez sélectionner une catégorie',
    )]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, DietType>
     */
    #[ORM\ManyToMany(targetEntity: DietType::class)]
    private Collection $diets;

    /**
     * @var Collection<int, CookingMethod>
     */
    #[Assert\Count(
        min: 1,
        minMessage: 'Vous devez sélectionner au moins {{ limit }} mode de cuisson',
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    #[ORM\ManyToMany(targetEntity: CookingMethod::class)]
    private Collection $cookingMethods;

    /**
     * @var Collection<int, Tag>
     */
    #[Assert\Count(
        max: self::MAX_TAGS,
        maxMessage: 'Vous pouvez ajouter jusqu\'à {{ limit }} tags',
    )]
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    /**
     * @var Collection<int, RecipeIngredient>
     */
    #[Assert\Count(
        min: self::MIN_INGREDIENTS,
        max: self::MAX_INGREDIENTS,
        minMessage: 'Vous devez ajouter au moins {{ limit }} ingredients',
        maxMessage: 'Vous pouvez ajouter jusqu\'à {{ limit }} ingredients',
        groups: [DraftRecipeStatusEnum::Ingredients->value],
    )]
    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: RecipeIngredient::class, mappedBy: 'recipe', cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $recipeIngredients;

    /**
     * @var Collection<int, Utensil>
     */
    #[ORM\ManyToMany(targetEntity: Utensil::class)]
    private Collection $utensils;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'recipe', orphanRemoval: true)]
    private Collection $steps;

    public function __construct()
    {
        $this->timer = new RecipeTimer();
        $this->quantityCounter = new QuantityCounter();
        $this->diets = new ArrayCollection();
        $this->cookingMethods = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
        $this->utensils = new ArrayCollection();
        $this->steps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPictureFile(): ?UploadedFile
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?UploadedFile $pictureFile): static
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getTimer(): RecipeTimer
    {
        return $this->timer;
    }

    public function setTimer(RecipeTimer $timer): static
    {
        $this->timer = $timer;

        return $this;
    }

    public function getQuantityCounter(): QuantityCounter
    {
        return $this->quantityCounter;
    }

    public function setQuantityCounter(QuantityCounter $quantityCounter): static
    {
        $this->quantityCounter = $quantityCounter;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, DietType>
     */
    public function getDiets(): Collection
    {
        return $this->diets;
    }

    public function addDiet(DietType $diet): static
    {
        if (!$this->diets->contains($diet)) {
            $this->diets->add($diet);
        }

        return $this;
    }

    public function removeDiet(DietType $diet): static
    {
        $this->diets->removeElement($diet);

        return $this;
    }

    /**
     * @return Collection<int, CookingMethod>
     */
    public function getCookingMethods(): Collection
    {
        return $this->cookingMethods;
    }

    public function addCookingMethod(CookingMethod $cookingMethod): static
    {
        if (!$this->cookingMethods->contains($cookingMethod)) {
            $this->cookingMethods->add($cookingMethod);
        }

        return $this;
    }

    public function removeCookingMethod(CookingMethod $cookingMethod): static
    {
        $this->cookingMethods->removeElement($cookingMethod);

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            if ($recipeIngredient->getRecipe() === $this) {
                $recipeIngredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utensil>
     */
    public function getUtensils(): Collection
    {
        return $this->utensils;
    }

    public function addUtensil(Utensil $utensil): static
    {
        if (!$this->utensils->contains($utensil)) {
            $this->utensils->add($utensil);
        }

        return $this;
    }

    public function removeUtensil(Utensil $utensil): static
    {
        $this->utensils->removeElement($utensil);

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    #[Assert\Callback]
    public function validateCookingMethod(ExecutionContextInterface $context): void
    {
        $singularCookingMethods = $this->cookingMethods->filter(function (CookingMethod $cookingMethod) {
            return $cookingMethod->isSingular();
        });

        if (count($singularCookingMethods) > 0 && count($this->cookingMethods) > 1) {
            $context
                ->buildViolation('Ces modes de cuisson sont incompatibles')
                ->atPath('cookingMethods')
                ->addViolation()
            ;
        }
    }

    #[Assert\Callback]
    public function validateIngredients(ExecutionContextInterface $context): void
    {
        $ingredients = [];
        $invalidIngredients = [];

        foreach ($this->recipeIngredients as $recipeIngredient) {
            $ingredient = $recipeIngredient->getIngredient();
            if (in_array($ingredient, $ingredients)) {
                if (!in_array($ingredient, $invalidIngredients)) {
                    $invalidIngredients[] = $ingredient;

                    $context
                        ->buildViolation(sprintf('L\'ingredient "%s" est présent plusieurs fois', $ingredient->getLabel()))
                        ->atPath('recipeIngredients')
                        ->addViolation()
                    ;
                }
            }

            $ingredients[] = $recipeIngredient->getIngredient();
        }
    }
}
