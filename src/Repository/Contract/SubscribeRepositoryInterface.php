<?php declare(strict_types=1);

namespace App\Repository\Contract;

use App\Model\Subscription;

interface SubscribeRepositoryInterface
{
    /**
     * @param int $chatId
     * @return Subscription[]
     */
    public function findAllByTelegramChatId(int $chatId): array;
}
