<?php declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Repository\Contract\SubscribeRepositoryInterface;
use App\Service\TwigService;
use App\Telegram\Repositories\StateRepository;
use App\Telegram\ValueObjects\OutgoingMessage;
use TelegramBot\Api\Types\Update;
use Twig\Environment;

class GetSubscribesCommand extends TelegramStyleCommand
{
    const COMMAND_NAME = 'getSubscribes';

    private SubscribeRepositoryInterface $subscribeRepository;

    private Environment $twig;

    public function __construct(
        SubscribeRepositoryInterface $subscribeRepository,
        Environment $twig
    ) {
        $this->subscribeRepository = $subscribeRepository;
        $this->twig = $twig;
    }

    public function execute(Update $update, StateRepository $stateRepository): ?OutgoingMessage
    {
        $subscribes = $this->subscribeRepository->findAllByTelegramChatId($this->getChatIdByUpdate($update));
        $renderedTemplate = $this->twig->render('telegram/subscribes-list.html.twig', ['subscribes' => $subscribes]);

        return new OutgoingMessage($this->getChatIdByUpdate($update), $renderedTemplate);
    }
}
