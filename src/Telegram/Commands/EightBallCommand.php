<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Telegram\Repositories\StateRepository;
use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Update;

class EightBallCommand extends TelegramStyleCommand
{
    const COMMAND_NAME = 'eightBall';

    const ANSWERS = [
        'Попробуй позже',
        'Все будет',
        'Да',
        'Нет',
        'А ты как думаешь?',
        'Возможно',
        'Очень маловероятно',
        'А я знаю?',
        'Мы сами творим свое будущее',
        'Вероятно',
        'Сомневаюсь',
        'Если бы ты знал(а) ответ на этот вопрос - ты бы не спрашивал(а)',
        'Your messages has been blocked by bot.',
        'Не знаю',
        'Я знаю ответ, но сказать не могу - обещал(',
        'Да нет, наверно',
        'Пффф',
        'Спроси меня об этом лучше в защищенном чате..',
        'Это запретная тема',
        '50/50',
        'Только тебе решать это, не перекладывай ответственность на меня за это',
        'Если чего-то хочешь очень сильно - оно обязательно сбудется',
    ];

    public function execute(Update $update, StateRepository $stateRepository): ?OutgoingMessage
    {
        $text = self::ANSWERS[rand(0, count(self::ANSWERS))];
        return new OutgoingMessage($update->getMessage()->getChat()->getId(), $text);
    }
}
