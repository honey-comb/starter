<?php
/**
 * @copyright 2019 innovationbase
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Contact InnovationBase:
 * E-mail: hello@innovationbase.eu
 * https://innovationbase.eu
 */

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
