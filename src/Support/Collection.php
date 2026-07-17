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

    /**
     * The first item, or null when the collection is empty.
     */
    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    /**
     * Whether the collection has no items.
     */
    public function isEmpty(): bool
    {
        return $this->items === [];
    }

    /**
     * Whether the collection has at least one item.
     */
    public function isNotEmpty(): bool
    {
        return $this->items !== [];
    }

    /**
     * Pagination metadata for this page of results, when available.
     */
    public function pagination(): ?Pagination
    {
        return $this->pagination;
    }

    /**
     * The number of items on this page (Countable).
     */
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

    /**
     * Whether an item exists at the given index (ArrayAccess).
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * Read the item at the given index, or null when absent (ArrayAccess).
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * Collections are immutable; always throws.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('MailerMine collections are immutable.');
    }

    /**
     * Collections are immutable; always throws.
     */
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
