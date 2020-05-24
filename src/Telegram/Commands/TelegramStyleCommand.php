<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\States\StateInterface;
use TelegramBot\Api\Types\Update;

abstract class TelegramStyleCommand implements CommandInterface
{
    public static function isAppliesTo(Update $update, StateInterface $state): bool
    {
        $pattern = '/^\/?' . static::COMMAND_NAME . '($|\s)/i';
        $text = $update->getMessage() ? $update->getMessage()->getText() : null;
        if ($text === null) {
            return false;
        }

        return (bool) preg_match($pattern, trim($text));
    }
}
