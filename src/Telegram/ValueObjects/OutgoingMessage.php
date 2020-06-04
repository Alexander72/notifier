<?php declare(strict_types=1);

namespace App\Telegram\ValueObjects;

class OutgoingMessage
{
    const PARSE_MODE_HTML = 'HTML';

    private int $chatId;

    private string $text;

    private string $parseMode;

    public function __construct(int $chatId, string $text)
    {
        $this->chatId = $chatId;
        $this->text = $text;
        $this->parseMode = self::PARSE_MODE_HTML;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getParseMode(): ?string
    {
        return $this->parseMode;
    }

    public function setParseMode(string $parseMode): void
    {
        $this->parseMode = $parseMode;
    }
}
