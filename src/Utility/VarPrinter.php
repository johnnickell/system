<?php declare(strict_types=1);

namespace Novuso\System\Utility;

use Closure;
use DateTimeInterface;
use Throwable;

/**
 * Class VarPrinter
 */
final class VarPrinter
{
    /**
     * Reads a string representation from a value
     *
     * @param mixed $value The value
     *
     * @return string
     */
    public static function toString($value): string
    {
        if ($value === null) {
            return 'NULL';
        }

        if ($value === true) {
            return 'TRUE';
        }

        if ($value === false) {
            return 'FALSE';
        }

        if (is_object($value)) {
            return static::readObject($value);
        }

        if (is_array($value)) {
            return static::readArray($value);
        }

        if (is_resource($value)) {
            return static::readResource($value);
        }

        return (string) $value;
    }

    /**
     * Reads a string representation from an object
     *
     * @param object $object The object
     *
     * @return string
     */
    protected static function readObject($object): string
    {
        if ($object instanceof Closure) {
            return 'Function';
        }

        if ($object instanceof DateTimeInterface) {
            return sprintf('%s(%s)', ClassName::short($object), $object->format('Y-m-d\TH:i:sP'));
        }

        if ($object instanceof Throwable) {
            return sprintf('%s(%s)', ClassName::short($object), json_encode([
                'message' => $object->getMessage(),
                'code'    => $object->getCode(),
                'file'    => $object->getFile(),
                'line'    => $object->getLine()
            ], JSON_UNESCAPED_SLASHES));
        }

        if (method_exists($object, 'toString')) {
            return (string) $object->toString();
        }

        if (method_exists($object, '__toString')) {
            return (string) $object;
        }

        return sprintf('Object(%s)', ClassName::full($object));
    }

    /**
     * Reads a string representation from an array
     *
     * @param array $array The array
     *
     * @return string
     */
    protected static function readArray(array $array): string
    {
        $data = [];

        foreach ($array as $key => $value) {
            $data[] = sprintf('%s => %s', $key, static::toString($value));
        }

        return sprintf('Array(%s)', implode(', ', $data));
    }

    /**
     * Reads a string representation from a resource
     *
     * @param resource $resource The resource
     *
     * @return string
     */
    protected static function readResource($resource): string
    {
        return sprintf('Resource(%s)', get_resource_type($resource));
    }
}
