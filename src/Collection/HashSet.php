<?php declare(strict_types=1);

namespace Novuso\System\Collection;

use Novuso\System\Collection\Chain\SetBucketChain;
use Novuso\System\Collection\Iterator\GeneratorIterator;
use Novuso\System\Collection\Mixin\ItemTypeMethods;
use Novuso\System\Collection\Type\Set;
use Novuso\System\Utility\Assert;
use Novuso\System\Utility\FastHasher;

/**
 * Class HashSet
 */
final class HashSet implements Set
{
    use ItemTypeMethods;

    /**
     * Bucket chains
     *
     * @var array
     */
    protected $buckets;

    /**
     * Bucket count
     *
     * @var int
     */
    protected $count;

    /**
     * Constructs HashSet
     *
     * If a type is not provided, the item type is dynamic.
     *
     * The type can be any fully-qualified class or interface name,
     * or one of the following type strings:
     * [array, object, bool, int, float, string, callable]
     *
     * @param string|null $itemType The item type
     */
    public function __construct(?string $itemType = null)
    {
        $this->setItemType($itemType);
        $this->buckets = [];
        $this->count = 0;
    }

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
     * @return HashSet
     */
    public static function of(?string $itemType = null): HashSet
    {
        return new static($itemType);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return $this->count === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function add($item): void
    {
        Assert::isType($item, $this->itemType());

        $hash = FastHasher::hash($item);

        if (!isset($this->buckets[$hash])) {
            $this->buckets[$hash] = new SetBucketChain();
        }

        if ($this->buckets[$hash]->add($item)) {
            $this->count++;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function contains($item): bool
    {
        $hash = FastHasher::hash($item);

        if (!isset($this->buckets[$hash])) {
            return false;
        }

        return $this->buckets[$hash]->contains($item);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($item): void
    {
        $hash = FastHasher::hash($item);

        if (isset($this->buckets[$hash])) {
            if ($this->buckets[$hash]->remove($item)) {
                $this->count--;
                if ($this->buckets[$hash]->isEmpty()) {
                    unset($this->buckets[$hash]);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function difference(Set $other)
    {
        $difference = static::of($this->itemType());

        if ($this === $other) {
            return $difference;
        }

        $this->reject([$other, 'contains'])->each([$difference, 'add']);
        $other->reject([$this, 'contains'])->each([$difference, 'add']);

        return $difference;
    }

    /**
     * {@inheritdoc}
     */
    public function intersection(Set $other)
    {
        $intersection = static::of($this->itemType());

        $this->filter([$other, 'contains'])->each([$intersection, 'add']);

        return $intersection;
    }

    /**
     * {@inheritdoc}
     */
    public function complement(Set $other)
    {
        $complement = static::of($this->itemType());

        if ($this === $other) {
            return $complement;
        }

        $other->reject([$this, 'contains'])->each([$complement, 'add']);

        return $complement;
    }

    /**
     * {@inheritdoc}
     */
    public function union(Set $other)
    {
        $union = static::of($this->itemType());

        $this->each([$union, 'add']);
        $other->each([$union, 'add']);

        return $union;
    }

    /**
     * {@inheritdoc}
     */
    public function each(callable $callback): void
    {
        foreach ($this->getIterator() as $index => $item) {
            call_user_func($callback, $item, $index);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callback, ?string $itemType = null)
    {
        $set = static::of($itemType);

        foreach ($this->getIterator() as $index => $item) {
            $set->add(call_user_func($callback, $item, $index));
        }

        return $set;
    }

    /**
     * {@inheritdoc}
     */
    public function max(?callable $callback = null)
    {
        if ($callback !== null) {
            $maxItem = null;
            $max = null;

            foreach ($this->getIterator() as $index => $item) {
                $field = call_user_func($callback, $item, $index);
                if ($max === null || $field > $max) {
                    $max = $field;
                    $maxItem = $item;
                }
            }

            return $maxItem;
        }

        return $this->reduce(function ($accumulator, $item) {
            return ($accumulator === null) || $item > $accumulator ? $item : $accumulator;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function min(?callable $callback = null)
    {
        if ($callback !== null) {
            $minItem = null;
            $min = null;

            foreach ($this->getIterator() as $index => $item) {
                $field = call_user_func($callback, $item, $index);
                if ($min === null || $field < $min) {
                    $min = $field;
                    $minItem = $item;
                }
            }

            return $minItem;
        }

        return $this->reduce(function ($accumulator, $item) {
            return ($accumulator === null) || $item < $accumulator ? $item : $accumulator;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callback, $initial = null)
    {
        $accumulator = $initial;

        foreach ($this->getIterator() as $index => $item) {
            $accumulator = call_user_func($callback, $accumulator, $item, $index);
        }

        return $accumulator;
    }

    /**
     * {@inheritdoc}
     */
    public function sum(?callable $callback = null)
    {
        if ($this->isEmpty()) {
            return null;
        }

        if ($callback === null) {
            $callback = function ($item) {
                return $item;
            };
        }

        return $this->reduce(function ($total, $item, $index) use ($callback) {
            return $total + call_user_func($callback, $item, $index);
        }, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function average(?callable $callback = null)
    {
        if ($this->isEmpty()) {
            return null;
        }

        $count = $this->count();

        return $this->sum($callback) / $count;
    }

    /**
     * {@inheritdoc}
     */
    public function find(callable $predicate)
    {
        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $predicate)
    {
        $set = static::of($this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $set->add($item);
            }
        }

        return $set;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(callable $predicate)
    {
        $set = static::of($this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (!call_user_func($predicate, $item, $index)) {
                $set->add($item);
            }
        }

        return $set;
    }

    /**
     * {@inheritdoc}
     */
    public function any(callable $predicate): bool
    {
        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function every(callable $predicate): bool
    {
        foreach ($this->getIterator() as $index => $item) {
            if (!call_user_func($predicate, $item, $index)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function partition(callable $predicate): array
    {
        $set1 = static::of($this->itemType());
        $set2 = static::of($this->itemType());

        foreach ($this->getIterator() as $index => $item) {
            if (call_user_func($predicate, $item, $index)) {
                $set1->add($item);
            } else {
                $set2->add($item);
            }
        }

        return [$set1, $set2];
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new GeneratorIterator(function (array $buckets) {
            $index = 0;
            /** @var SetBucketChain $chain */
            foreach ($buckets as $chain) {
                for ($chain->rewind(); $chain->valid(); $chain->next()) {
                    yield $index => $chain->current();
                    $index++;
                }
            }
        }, [$this->buckets]);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $items = [];

        foreach ($this->getIterator() as $item) {
            $items[] = $item;
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = JSON_UNESCAPED_SLASHES): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->toJson();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Handles deep cloning
     *
     * @return void
     */
    public function __clone()
    {
        $buckets = [];

        foreach ($this->buckets as $hash => $chain) {
            $buckets[$hash] = clone $chain;
        }

        $this->buckets = $buckets;
    }
}
