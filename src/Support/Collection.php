<?php

declare(strict_types=1);

namespace MailerMine\Support;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use LogicException;
use Traversable;

/**
 * Immutable collection of API resource items.
 *
 * @implements ArrayAccess<int, mixed>
 * @implements IteratorAggregate<int, mixed>
 */
final class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * @param  list<mixed>  $items
     */
    public function __construct(
        private readonly array $items = [],
        private readonly ?Pagination $pagination = null,
    ) {}

    /**
     * @return list<mixed>
     */
    public function all(): array
    {
        return $this->items;
    }

    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    public function isEmpty(): bool
    {
        return $this->items === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->items !== [];
    }

    public function pagination(): ?Pagination
    {
        return $this->pagination;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return Traversable<int, mixed>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('MailerMine collections are immutable.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('MailerMine collections are immutable.');
    }

    /**
     * @return array{data: list<mixed>, meta: array<string, int>|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->items,
            'meta' => $this->pagination?->toArray(),
        ];
    }

    /**
     * @return list<mixed>
     */
    public function toArray(): array
    {
        return array_map(
            static function (mixed $item): mixed {
                if ($item instanceof JsonSerializable) {
                    return $item->jsonSerialize();
                }

                if (is_object($item) && method_exists($item, 'toArray')) {
                    return $item->toArray();
                }

                return $item;
            },
            $this->items,
        );
    }
}
