<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * CollectionInterface is the base interface for collection types
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface CollectionInterface extends Countable, IteratorAggregate
{
    /**
     * Checks if empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Retrieves the number of elements
     *
     * @return int
     */
    public function count(): int;

    /**
     * Retrieves an iterator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable;
}