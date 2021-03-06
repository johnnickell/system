<?php declare(strict_types=1);

namespace Novuso\System\Collection\Tree;

/**
 * Class RedBlackNode
 */
final class RedBlackNode
{
    /**
     * Red link
     *
     * @var bool
     */
    public const RED = true;

    /**
     * Black link
     *
     * @var bool
     */
    public const BLACK = false;

    /**
     * Left subtree
     *
     * @var RedBlackNode|null
     */
    protected $left;

    /**
     * Right subtree
     *
     * @var RedBlackNode|null
     */
    protected $right;

    /**
     * Node key
     *
     * @var mixed
     */
    protected $key;

    /**
     * Node value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Subtree size
     *
     * @var int
     */
    protected $size;

    /**
     * Parent link color
     *
     * @var bool
     */
    protected $color;

    /**
     * Constructs RedBlackNode
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     * @param int   $size  The size
     * @param bool  $color The color constant
     */
    public function __construct($key, $value, int $size, bool $color)
    {
        $this->key = $key;
        $this->value = $value;
        $this->size = $size;
        $this->color = $color;
    }

    /**
     * Sets the left node
     *
     * @param RedBlackNode|null $left A RedBlackNode instance or null to unset
     *
     * @return void
     */
    public function setLeft(?RedBlackNode $left): void
    {
        $this->left = $left;
    }

    /**
     * Retrieves the left node
     *
     * @return RedBlackNode|null
     */
    public function left(): ?RedBlackNode
    {
        return $this->left;
    }

    /**
     * Sets the right node
     *
     * @param RedBlackNode|null $right A RedBlackNode instance or null to unset
     *
     * @return void
     */
    public function setRight(?RedBlackNode $right): void
    {
        $this->right = $right;
    }

    /**
     * Retrieves the right node
     *
     * @return RedBlackNode|null
     */
    public function right(): ?RedBlackNode
    {
        return $this->right;
    }

    /**
     * Sets the key
     *
     * @param mixed $key The key
     *
     * @return void
     */
    public function setKey($key): void
    {
        $this->key = $key;
    }

    /**
     * Retrieves the key
     *
     * @return mixed
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Sets the value
     *
     * @param mixed $value The value
     *
     * @return void
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * Retrieves the value
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Sets the size
     *
     * @param int $size The size
     *
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Retrieves the size
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * Sets the color flag
     *
     * @param bool $color Either RedBlackNode::RED or RedBlackNode::BLACK
     *
     * @return void
     */
    public function setColor(bool $color): void
    {
        $this->color = $color;
    }

    /**
     * Retrieves the color flag
     *
     * @return bool
     */
    public function color(): bool
    {
        return $this->color;
    }

    /**
     * Handles deep cloning
     *
     * @return void
     */
    public function __clone()
    {
        if ($this->left !== null) {
            $left = clone $this->left;
            $this->left = $left;
        }

        if ($this->right !== null) {
            $right = clone $this->right;
            $this->right = $right;
        }
    }
}
