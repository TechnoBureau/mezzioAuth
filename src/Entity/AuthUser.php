<?php
declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mezzio\Authentication\UserInterface as MezzioUserInterface;

#[ORM\Table(name: 'auth_user', uniqueConstraints: [new ORM\UniqueConstraint(name: 'auth_user_username_key', columns: ['username'])], indexes: [new ORM\Index(name: 'auth_user_username_6821ab7c_like', columns: ['username'])])]
#[ORM\Entity(repositoryClass: \TechnoBureau\mezzioAuth\Repository\AuthUserRepository::class)]
class AuthUser implements MezzioUserInterface
{
    #[ORM\Column(name: "id", type: "integer", options: ["unsigned" => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private string $first_name;

    #[ORM\Column(name: "role", type: "string", length: 255, nullable: true)]
    private string $role;

    #[ORM\Column(name: "active", type: "boolean", options: ["default" => 0])]
    private bool $isActive = false;

    private array $roles = [];

    private array $details = [];

    // #[ORM\ManyToMany(targetEntity:"AuthGroup", mappedBy:"users") ]
    // protected $groups;

    #[ORM\ManyToMany(targetEntity: 'AuthGroup', inversedBy: 'users')]
    #[ORM\JoinTable(name: 'auth_user_group')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'group_id', referencedColumnName: 'id')]
    private $groups;

    public function __construct()
    {
        $this->id = 0;
        $this->email = '';
        $this->first_name = '';
        $this->password = '';
        $this->role = '';
        $this->groups = new ArrayCollection();
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

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setIsActive(bool $isActive = true): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getIdentity(): string
    {
        return $this->getEmail();
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles(): array
    {
        return explode (",", $this->role);
    }

    public function getDetail(string $name, $default = null)
    {
        return $this->details[$name] ?? $default;
    }

    public function setDetails(array $details): self
    {
        $this->details = $details;

        return $this;
    }

    /** @psalm-suppress MixedReturnTypeCoercion */
    public function getDetails(): array
    {
        /** @psalm-suppress MixedReturnTypeCoercion */
        $this->details['first_name']=$this->first_name;
        return $this->details;
    }

    /**
     * Returns groups for this user.
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Adds a new group to this user.
     * @param $group
     */
    public function addGroup($group)
    {
        $this->group[] = $group;
    }
}