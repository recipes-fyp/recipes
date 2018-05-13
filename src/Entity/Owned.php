<?php

namespace App\Entity;


trait Owned {

    /**
     * visibiloty and editing rules
     */


    public function isOwned(User $user = null) : string {
        $id = $user ? $user->getId() : "none";
        return $this->getUserId() . " == " . $id ;
        return $this->isOwner() ? "Yes" : "No" ;
    } 
    public function isOwner(User $user = null) : bool 
    {
        return $user && ($user->getId() == $this->getUserId() );
    }
    public function isEditable(User $user = null) : bool 
    {
        return $this->isOwner($user);
    }
    public function isVisble(User $user = null) : bool 
    {
        return $this->isPublic || $this->isShared || $this->isOwner($user);
    }

    public function getUserId() {
        return $this->user->getId();
    }

	

} 