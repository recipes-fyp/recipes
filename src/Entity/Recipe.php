<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */
class Recipe
{
    use Owned;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="text", length=3000, nullable=true)
     */
    private $steps;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $ingredients;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recipes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPublic;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isShared;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="recipe", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Coll", inversedBy="recipes")
     */
    private $coll;

    // *
    //  * @ORM\ManyToOne(targetEntity="App\Entity\Coll", inversedBy="recipes")
    //  * @ORM\Column(nullable=true)
     
    // private $coll;

    public function __construct() {
        $this->created = new \DateTime();
        $this->comments = new ArrayCollection();
        // can't find the current user!!
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }


    /**
     * @param string $title
     * @return Recipe
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param null|string $summary
     * @return Recipe
     */
    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    /**
     * @param \DateTimeInterface|null $created
     * @return Recipe
     */
    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSteps(): ?string
    {
        return $this->steps;
    }

    /**
     * @param null|string $steps
     * @return Recipe
     */
    public function setSteps(?string $steps): self
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    /**
     * @param null|string $ingredients
     * @return Recipe
     */
    public function setIngredients(?string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(?bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getIsShared(): ?bool
    {
        return $this->isShared;
    }

    public function setIsShared(?bool $isShared): self
    {
        $this->isShared = $isShared;

        return $this;
    }


    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->title;
    }

    public function getColl(): ?Coll
    {
        return $this->coll;
    }

    public function setColl(?Coll $coll): self
    {
        $this->coll = $coll;

        return $this;
    }    
}

