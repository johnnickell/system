<?php declare(strict_types=1);

namespace Novuso\System\Test\Resources;

use Novuso\System\Exception\DomainException;
use Novuso\System\Serialization\Serializable;
use Novuso\System\Type\Comparable;
use Novuso\System\Utility\Assert;

/**
 * Class TestUser
 */
class TestUser implements Comparable, Serializable
{
    protected $lastName;
    protected $firstName;
    protected $username;
    protected $email;
    protected $birthDate;

    public function __construct(array $data)
    {
        $this->lastName = $data['lastName'];
        $this->firstName = $data['firstName'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->birthDate = $data['birthDate'];
    }

    public static function arrayDeserialize(array $data)
    {
        $keys = ['lastName', 'firstName', 'username', 'email', 'birthDate'];
        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                $message = sprintf('Serialization key missing: %s', $key);
                throw new DomainException($message);
            }
        }

        return new static($data);
    }

    public function arraySerialize(): array
    {
        return $this->toArray();
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function username()
    {
        return $this->username;
    }

    public function email()
    {
        return $this->email;
    }

    public function birthDate()
    {
        return $this->birthDate;
    }

    public function toArray(): array
    {
        return [
            'lastName'  => $this->lastName,
            'firstName' => $this->firstName,
            'username'  => $this->username,
            'email'     => $this->email,
            'birthDate' => $this->birthDate
        ];
    }

    public function compareTo($object): int
    {
        if ($this === $object) {
            return 0;
        }

        Assert::areSameType($this, $object);

        $comp = strnatcmp($this->username(), $object->username());

        if ($comp > 0) {
            return 1;
        }
        if ($comp < 0) {
            return -1;
        }

        return 0;
    }
}
