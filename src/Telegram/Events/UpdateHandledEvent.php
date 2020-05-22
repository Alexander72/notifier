<?php declare(strict_types=1);

namespace App\Telegram\Events;

use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Update;

class UpdateHandledEvent
{
    public function __construct(Update $update, ?OutgoingMessage $handleResult)
    {
    }
}
