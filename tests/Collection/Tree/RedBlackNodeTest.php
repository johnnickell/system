<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection\Tree;

use Novuso\System\Collection\Tree\RedBlackNode;
use Novuso\System\Test\Resources\TestWeekDay;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Tree\RedBlackNode
 */
class RedBlackNodeTest extends UnitTestCase
{
    public function test_that_constructor_takes_key_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $this->assertSame($monday, $node->key());
    }

    public function test_that_constructor_takes_value_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $this->assertSame('Monday', $node->value());
    }

    public function test_that_constructor_takes_size_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $this->assertSame(1, $node->size());
    }

    public function test_that_constructor_takes_color_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $this->assertSame(RedBlackNode::RED, $node->color());
    }

    public function test_that_left_holds_reference_to_left_node()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $sunday = TestWeekDay::SUNDAY();
        $left = new RedBlackNode($sunday, 'Sunday', 1, RedBlackNode::RED);
        $node->setLeft($left);
        $this->assertSame($left, $node->left());
    }

    public function test_that_right_holds_reference_to_right_node()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $tuesday = TestWeekDay::TUESDAY();
        $right = new RedBlackNode($tuesday, 'Tuesday', 1, RedBlackNode::RED);
        $node->setRight($right);
        $this->assertSame($right, $node->right());
    }

    public function test_that_it_allows_key_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $sunday = TestWeekDay::SUNDAY();
        $node->setKey($sunday);
        $this->assertSame($sunday, $node->key());
    }

    public function test_that_it_allows_value_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $node->setValue('Sunday');
        $this->assertSame('Sunday', $node->value());
    }

    public function test_that_it_allows_size_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $node->setSize(2);
        $this->assertSame(2, $node->size());
    }

    public function test_that_it_allows_color_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $node->setColor(RedBlackNode::BLACK);
        $this->assertSame(RedBlackNode::BLACK, $node->color());
    }

    public function test_that_clone_includes_linked_nodes()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $sunday = TestWeekDay::SUNDAY();
        $left = new RedBlackNode($sunday, 'Sunday', 1, RedBlackNode::RED);
        $node->setLeft($left);
        $tuesday = TestWeekDay::TUESDAY();
        $right = new RedBlackNode($tuesday, 'Tuesday', 1, RedBlackNode::RED);
        $node->setRight($right);
        $copy = clone $node;
        $node->setLeft(null);
        $node->setRight(null);
        $this->assertTrue($copy->left()->key()->equals($sunday));
    }
}
