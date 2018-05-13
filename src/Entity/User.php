<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Coll;
use App\Entity\Recipe;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser {
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
     protected $id;
 
     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Recipe", mappedBy="user", orphanRemoval=true)
      */
     private $recipes;
 
     /**
      * @ORM\Column(type="boolean", nullable=true)
      */
     private $isAdmin;
 
     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
      */
     private $comments;
 
     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Coll", mappedBy="user")
      */
     private $colls;
 

     public function __construct()
     {
         $this->recipes = new ArrayCollection();
         $this->comments = new ArrayCollection();
         $this->colls = new ArrayCollection();
     }
     // this does not work - need to use controller
     public function isLoggedIn() :?bool
     {
        return $this->isGranted('ROLE_USER'); 
     }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Recipe[]
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
            $recipe->setUser($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->contains($recipe)) {
            $this->recipes->removeElement($recipe);
            // set the owning side to null (unless already changed)
            if ($recipe->getUser() === $this) {
                $recipe->setUser(null);
            }
        }

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Coll[]
     */
    public function getColls(): Collection
    {
        return $this->colls;
    }

    public function addColl(Coll $coll): self
    {
        if (!$this->colls->contains($coll)) {
            $this->coll[] = $coll;
            $coll->setUser($this);
        }

        return $this;
    }

    public function removeColl(Coll $coll): self
    {
        if ($this->colls->contains($coll)) {
            $this->coll->removeElement($coll);
            // set the owning side to null (unless already changed)
            if ($coll->getUser() === $this) {
                $coll->setUser(null);
            }
        }

        return $this;
    }

 


}