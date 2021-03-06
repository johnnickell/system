<?php declare(strict_types=1);

namespace Novuso\System\Collection\Tree;

use Countable;
use Novuso\System\Exception\KeyException;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;

/**
 * Interface BinarySearchTree
 */
interface BinarySearchTree extends Countable
{
    /**
     * Checks if empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Retrieves the number of nodes
     *
     * @return int
     */
    public function count(): int;

    /**
     * Sets a key/value pair
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     *
     * @return void
     */
    public function set($key, $value): void;

    /**
     * Retrieves a value by key
     *
     * @param mixed $key The key
     *
     * @return mixed
     *
     * @throws KeyException When the key is not defined
     */
    public function get($key);

    /**
     * Checks if a key is defined
     *
     * @param mixed $key The key
     *
     * @return bool
     */
    public function has($key): bool;

    /**
     * Removes a key-value pair by key
     *
     * @param mixed $key The key
     *
     * @return void
     */
    public function remove($key): void;

    /**
     * Retrieves an iterator for keys
     *
     * @return iterable
     */
    public function keys(): iterable;

    /**
     * Retrieves an inclusive list of keys between given keys
     *
     * @param mixed $lo The lower bound
     * @param mixed $hi The upper bound
     *
     * @return iterable
     */
    public function rangeKeys($lo, $hi): iterable;

    /**
     * Retrieves the inclusive number of keys between given keys
     *
     * @param mixed $lo The lower bound
     * @param mixed $hi The upper bound
     *
     * @return int
     */
    public function rangeCount($lo, $hi): int;

    /**
     * Retrieves the minimum key
     *
     * @return mixed
     *
     * @throws UnderflowException When the tree is empty
     */
    public function min();

    /**
     * Retrieves the maximum key
     *
     * @return mixed
     *
     * @throws UnderflowException When the tree is empty
     */
    public function max();

    /**
     * Removes the key-value pair with the minimum key
     *
     * @return void
     *
     * @throws UnderflowException When the tree is empty
     */
    public function removeMin(): void;

    /**
     * Removes the key-value pair with the maximum key
     *
     * @return void
     *
     * @throws UnderflowException When the tree is empty
     */
    public function removeMax(): void;

    /**
     * Retrieves the largest key less or equal to the given key
     *
     * Returns null if there is not a key less or equal to the given key.
     *
     * @param mixed $key The key
     *
     * @return mixed|null
     *
     * @throws UnderflowException When the tree is empty
     */
    public function floor($key);

    /**
     * Retrieves the smallest key greater or equal to the given key
     *
     * Returns null if there is not a key greater or equal to the given key.
     *
     * @param mixed $key The key
     *
     * @return mixed|null
     *
     * @throws UnderflowException When the tree is empty
     */
    public function ceiling($key);

    /**
     * Retrieves the rank of the given key
     *
     * @param mixed $key The key
     *
     * @return int
     */
    public function rank($key): int;

    /**
     * Retrieves the key with the given rank
     *
     * @param int $rank The rank
     *
     * @return mixed
     *
     * @throws LookupException When the rank is not valid
     */
    public function select(int $rank);
}
