<?php declare(strict_types=1);

namespace App\Telegram\Repositories;

use App\Service\RedisService;
use Redis;

class UpdateDataRepository
{
    const LAST_UPDATE_CACHE_KEY = 'notifier.telegram.last_update_id';

    private Redis $redis;

    public function __construct(RedisService $redisService)
    {
        $this->redis = $redisService->getRedis();
    }

    public function saveLastUpdateId(int $updateId)
    {
        $this->redis->set(self::LAST_UPDATE_CACHE_KEY, $updateId);
    }

    public function getLastUpdateId(): ?int
    {
        $lastUpdateId = $this->redis->get(self::LAST_UPDATE_CACHE_KEY);

        return $lastUpdateId === false ? null : (int) $lastUpdateId;
    }
}
