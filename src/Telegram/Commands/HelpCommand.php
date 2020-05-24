<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Update;

class HelpCommand extends TelegramStyleCommand
{
    const COMMAND_NAME = 'help';

    public function execute(Update $update): ?OutgoingMessage
    {
        if (!$update->getMessage()) {
            return null;
        }

        return new OutgoingMessage($update->getMessage()->getChat()->getId(), 'Help message');
    }
}
