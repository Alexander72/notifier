<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\States\StateInterface;
use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;

interface CommandInterface
{
    public static function isAppliesTo(Update $update, StateInterface $state): bool;

    public function execute(Message $message): ?OutgoingMessage;
}
