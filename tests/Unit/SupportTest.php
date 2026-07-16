<?php

declare(strict_types=1);

namespace MailerMine\Tests\Unit;

use MailerMine\Support\Collection;
use MailerMine\Support\Pagination;
use MailerMine\Support\Response;
use MailerMine\Tests\TestCase;

final class SupportTest extends TestCase
{
    public function test_response_extracts_data_and_message(): void
    {
        $payload = new class
        {
            public function getData(): array
            {
                return ['id' => 'abc'];
            }

            public function getMessage(): string
            {
                return 'ok';
            }

            public function getSuccess(): bool
            {
                return true;
            }

            public function jsonSerialize(): array
            {
                return [
                    'success' => true,
                    'message' => 'ok',
                    'data' => ['id' => 'abc'],
                ];
            }
        };

        $response = Response::from($payload);

        $this->assertSame(['id' => 'abc'], $response->data());
        $this->assertSame('ok', $response->message());
        $this->assertTrue($response->success());
    }

    public function test_collection_is_immutable_and_countable(): void
    {
        $pagination = new Pagination(1, 15, 2, 1);
        $collection = new Collection(['a', 'b'], $pagination);

        $this->assertCount(2, $collection);
        $this->assertSame('a', $collection->first());
        $this->assertSame($pagination, $collection->pagination());
        $this->assertTrue($collection->isNotEmpty());
    }
}
