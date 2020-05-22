<?php declare(strict_types=1);

namespace App\Telegram\ValueObjects;

class OutgoingMessage
{
    private int $chatId;

    private string $text;

    public function __construct(int $chatId, string $text)
    {
        $this->chatId = $chatId;
        $this->text = $text;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
