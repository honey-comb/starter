<?php


declare(strict_types = 1);

namespace Tests\DTO;


use HoneyComb\Starter\DTO\HCBaseDTO;
use Tests\TestCase;

/**
 * Class HCBaseDTOTest
 * @package Tests\DTO
 */
class HCBaseDTOTest extends TestCase
{
    /**
     * @test
     */
    public function it_must_return_valid_array_data(): void
    {
        $dto = (new TestUserDTO('John', 'john@example.com', 'password123'));

        $this->assertEquals([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'description' => null,
        ], $dto->toArray());

        $this->assertEquals([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'description' => null,
        ], $dto->jsonSerialize());
    }
}


class TestUserDTO extends HCBaseDTO
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var null|string
     */
    private $description;

    /**
     * TestUserDTO constructor.
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string|null $description
     */
    public function __construct(string $name, string $email, string $password, string $description = null)
    {

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    protected function jsonData(): array
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'description' => $this->getDescription(),
        ];
    }
}
