<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use PharIo\Manifest\Email;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Model\Filter\Customers\CustomerFilter;
use RetailCrm\Api\Model\Request\Customers\CustomersRequest;
use Symfony\Component\Security\Core\User\EquatableInterface;


#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{ 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public $firstname;
    public $lastname;
    public $patronymic;
    public $phone;
    public $birthday;
    public $address;
    public $sex;
    public $payment;
    public $delivery;
    public $retailId;
    public $isCrmLoad = false;

   

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function crmLoad()
    {
        if(!$this->isCrmLoad && $this->uuid)
        {
            $Users = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $_ENV['API_KEY']);

            $customersRequest = new CustomersRequest();
            $customersRequest->filter = new CustomerFilter();
            $customersRequest->filter->externalIds = [$this->uuid];

            try {
                $customersResponse = $Users->customers->list($customersRequest);
                if (0 === count($customersResponse->customers)) return false;
                
                $resultUsers = $customersResponse->customers[0];
                $this->firstname = $resultUsers->firstName;
                $this->lastname = $resultUsers->lastName;
                $this->patronymic = $resultUsers->patronymic;
                $this->phone = $resultUsers->phones[0]->number;
                $this->birthday = $resultUsers->birthday;
                $this->address = isset($resultUsers->address) ? $resultUsers->address->text : null;
                $this->sex = $resultUsers->sex;

                $this->isCrmLoad = true;

            } catch (Exception $exception) {
                dd($exception);
                exit(-1);
            }

            return true;
        } else {
            return false;
        }
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if ($user instanceof self) {
            return $user->getId() === $this->getId();
        }

        return false;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }
}