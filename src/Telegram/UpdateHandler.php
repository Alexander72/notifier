<?php declare(strict_types=1);

namespace App\Telegram;

use App\Telegram\Events\UpdateHandledEvent;
use App\Telegram\Events\UpdateReceivedEvent;
use App\Telegram\Repositories\StateRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

class UpdateHandler
{
    private EventDispatcherInterface $eventDispatcher;

    private CommandManager $commandManager;

    private BotApi $telegramClient;

    private StateRepository $stateRepository;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        CommandManager $commandManager,
        BotApi $telegramClient,
        StateRepository $stateRepository
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->commandManager = $commandManager;
        $this->telegramClient = $telegramClient;
        $this->stateRepository = $stateRepository;
    }

    public function handle(array $update): void
    {
        $update = Update::fromResponse($update);

        $this->eventDispatcher->dispatch(new UpdateReceivedEvent($update));

        $command = $this->commandManager->getCommand($update);
        $response = $command->execute($update, $this->stateRepository);

        if($response) {
            $this->telegramClient->sendMessage($response->getChatId(), $response->getText(), $response->getParseMode());
        }

        $this->eventDispatcher->dispatch(new UpdateHandledEvent($update, $response));
    }
}
