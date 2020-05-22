<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\States\StateInterface;
use TelegramBot\Api\Types\Update;

abstract class TelegramStyleCommand implements CommandInterface
{
    public static function isAppliesTo(Update $update, StateInterface $state): bool
    {
        return (bool) preg_match('/^\/?' . static::COMMAND_NAME . '($|\s)/i', trim($update->getMessage()->getText()));
    }
}
