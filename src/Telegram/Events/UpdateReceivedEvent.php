<?php declare(strict_types=1);

namespace App\Telegram\Events;

use TelegramBot\Api\Types\Update;

class UpdateReceivedEvent
{
    public function __construct(Update $update)
    {
    }
}
