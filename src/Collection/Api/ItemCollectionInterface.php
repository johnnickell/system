<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

/**
 * ItemCollectionInterface is the interface for item collections
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface ItemCollectionInterface extends CollectionInterface
{
    /**
     * Creates collection of a specific item type
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $itemType The item type
     *
     * @return ItemCollectionInterface
     */
    public static function of(?string $itemType = null);

    /**
     * Retrieves the item type
     *
     * Returns null if the collection type is dynamic.
     *
     * @return string|null
     */
    public function itemType(): ?string;

    /**
     * Applies a callback function to every item
     *
     * Callback signature:
     *
     * <code>
     * function ($item) {}
     * </code>
     *
     * @param callable $callback The callback
     *
     * @return void
     */
    public function each(callable $callback): void;

    /**
     * Creates a collection from the results of a function
     *
     * Callback signature:
     *
     * <code>
     * function ($item): $newItem {}
     * </code>
     *
     * @param callable    $callback The callback
     * @param string|null $itemType The item type for the new collection
     *
     * @return ItemCollectionInterface
     */
    public function map(callable $callback, ?string $itemType = null);

    /**
     * Retrieves the first item that passes a truth test
     *
     * Returns null if no item passes the test.
     *
     * Predicate signature:
     *
     * <code>
     * function ($item): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return mixed|null
     */
    public function find(callable $predicate);

    /**
     * Creates a collection from items that pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($item): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return ItemCollectionInterface
     */
    public function filter(callable $predicate);

    /**
     * Creates a collection from items that fail a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($item): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return ItemCollectionInterface
     */
    public function reject(callable $predicate);

    /**
     * Checks if any items pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($item): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return bool
     */
    public function any(callable $predicate): bool;

    /**
     * Checks if all items pass a truth test
     *
     * Predicate signature:
     *
     * <code>
     * function ($item): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return bool
     */
    public function every(callable $predicate): bool;

    /**
     * Creates two collections based on a truth test
     *
     * Items that pass the truth test are placed in the first collection.
     *
     * Items that fail the truth test are placed in the second collection.
     *
     * Predicate signature:
     *
     * <code>
     * function ($item): bool {}
     * </code>
     *
     * @param callable $predicate The predicate function
     *
     * @return ItemCollectionInterface[]
     */
    public function partition(callable $predicate): array;
}