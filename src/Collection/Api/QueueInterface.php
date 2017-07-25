<?php declare(strict_types=1);

namespace Novuso\System\Collection\Api;

use Novuso\System\Exception\UnderflowException;

/**
 * QueueInterface is the interface for the queue type
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
interface QueueInterface extends ItemCollectionInterface
{
    /**
     * Adds an item to the end
     *
     * @param mixed $item The item
     *
     * @return void
     */
    public function enqueue($item): void;

    /**
     * Removes and returns the front item
     *
     * @return mixed
     *
     * @throws UnderflowException When the queue is empty
     */
    public function dequeue();

    /**
     * Retrieves the front item without removal
     *
     * @return mixed
     *
     * @throws UnderflowException When the queue is empty
     */
    public function front();
}