<?php declare(strict_types=1);

namespace App\Telegram;

use App\Telegram\Commands\CommandInterface;
use App\Telegram\Commands\EchoCommand;
use App\Telegram\Commands\HelpCommand;
use App\Telegram\States\NullState;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use TelegramBot\Api\Types\Update;

class CommandManager implements ServiceSubscriberInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function getDefaultCommand(): ?string
    {
        return HelpCommand::class;
    }

    public static function getSubscribedServices()
    {
        return [
            EchoCommand::class => EchoCommand::class,
            HelpCommand::class => HelpCommand::class,
        ];
    }

    public function getCommand(Update $update): CommandInterface
    {
        foreach($this->getSubscribedServices() as $commandClass) {
            if ($commandClass::isAppliesTo($update, new NullState())) {
                return $this->container->get($commandClass);
            }
        }

        return $this->container->get($this->getDefaultCommand());
    }
}
