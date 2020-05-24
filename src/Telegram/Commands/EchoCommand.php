<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Update;

class EchoCommand extends TelegramStyleCommand
{
    const COMMAND_NAME = 'echo';

    public function execute(Update $update): ?OutgoingMessage
    {
        if (!$update->getMessage()) {
            return null;
        }

        $text = preg_replace('/\/?echo\s+/', '', $update->getMessage()->getText());
        return new OutgoingMessage($update->getMessage()->getChat()->getId(), $text);
    }
}
