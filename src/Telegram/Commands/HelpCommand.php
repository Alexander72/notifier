<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Message;

class HelpCommand extends TelegramStyleCommand
{
    const COMMAND_NAME = 'help';

    public function execute(Message $message): ?OutgoingMessage
    {
        return new OutgoingMessage($message->getChat()->getId(), 'Help message');
    }
}
