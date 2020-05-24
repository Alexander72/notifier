<?php declare(strict_types=1);

namespace App\Telegram\Repositories;

use App\Service\RedisService;
use App\Telegram\States\NullState;
use App\Telegram\States\StateInterface;

class StateRepository
{
    const CACHE_KEY_PREFIX = 'notifier.telegram.state.';

    const TTL_IN_SECONDS = 60 * 30;

    private RedisService $redisService;

    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function findStateByChatId(int $chatId): StateInterface
    {
        $stateName = $this->redisService->getRedis()->get($this->getCacheKey($chatId));
        if (!$stateName) {
            return new NullState();
        }

        return $this->stateResolver->getState($stateName);
    }

    public function saveState(int $chatId, string $state)
    {
        $this->redisService->getRedis()->set($this->getCacheKey($chatId), $state, self::TTL_IN_SECONDS);
    }

    private function getCacheKey(int $chatId): string
    {
        return self::CACHE_KEY_PREFIX . $chatId;
    }
}
