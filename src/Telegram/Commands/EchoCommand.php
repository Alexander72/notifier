<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Message;

class EchoCommand extends TelegramStyleCommand
{
    const COMMAND_NAME = 'echo';

    public function execute(Message $message): ?OutgoingMessage
    {
        $text = preg_replace('/\/?echo\s+/', '', $message->getText());
        return new OutgoingMessage($message->getChat()->getId(), $text);
    }
}
