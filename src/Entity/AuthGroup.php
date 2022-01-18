<?php
declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'auth_group', uniqueConstraints: [new ORM\UniqueConstraint(name: 'auth_group_name_key', columns: ['name'])], indexes: [new ORM\Index(name: 'auth_group_name_a6ea08ec_like', columns: ['name'])])]
#[ORM\Entity]
class AuthGroup
{
    #[ORM\Column(name: "id", type: "integer", options: ["unsigned" => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;


    #[ORM\ManyToMany(targetEntity:"AuthUser", mappedBy:"groups") ]
    private $users;


    public function __construct()
    {
        $this->id = 0;
        $this->name = '';
        $this->users = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns users which have this group.
     * @return type
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Adds a user which has this group.
     * @param type $user
     */
    public function addUser($user)
    {
        $this->users[] = $user;
    }

}