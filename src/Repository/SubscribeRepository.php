<?php declare(strict_types=1);

namespace App\Repository;

use App\Model\Subscription;
use App\Repository\Contract\SubscribeRepositoryInterface;

class SubscribeRepository implements SubscribeRepositoryInterface
{
    public function findAllByTelegramChatId(int $chatId): array
    {
        return [
            new Subscription(1, 'Test subscription'),
            new Subscription(2, 'Test subscription 2'),
        ];
    }
}
