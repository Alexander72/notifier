<?php declare(strict_types=1);

namespace App\Service;

use Redis;

class RedisService
{
    private string $redisHost;

    private Redis $redis;

    public function __construct(string $redisHost)
    {
        $this->redisHost = $redisHost;
        $this->redis = new Redis();
    }

    public function getRedis(): Redis
    {
        if (!$this->redis->isConnected()) {
            $this->redis->connect($this->redisHost);
        }

        return $this->redis;
    }
}
