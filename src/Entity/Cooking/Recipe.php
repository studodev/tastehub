<?php

namespace App\Entity\Cooking;

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

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
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
        max: 350,
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

    #[ORM\Column(type: JsonDocumentType::NAME)]
    private RecipeTimer $timer;

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
    #[ORM\ManyToMany(targetEntity: CookingMethod::class)]
    private Collection $cookingMethods;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    /**
     * @var Collection<int, RecipeIngredient>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngredient::class, mappedBy: 'recipe', orphanRemoval: true)]
    private Collection $recipeIngredients;

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
}
