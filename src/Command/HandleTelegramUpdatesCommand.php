<?php declare(strict_types=1);

namespace App\Command;

use App\Telegram\Repositories\UpdateDataRepository;
use App\Telegram\UpdateHandler;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;

class HandleTelegramUpdatesCommand extends Command
{
    protected static $defaultName = 'telegram:handleUpdates';

    private UpdateHandler $updateHandler;

    private ClientInterface $client;

    private LoggerInterface $logger;

    private UpdateDataRepository $updateDataRepository;

    private string $telegramBotToken;

    public function __construct(
        ClientInterface $client,
        UpdateHandler $updateHandler,
        LoggerInterface $logger,
        UpdateDataRepository $updateDataRepository,
        string $telegramBotToken
    ) {
        parent::__construct();

        $this->updateHandler = $updateHandler;
        $this->client = $client;
        $this->logger = $logger;
        $this->updateDataRepository = $updateDataRepository;
        $this->telegramBotToken = $telegramBotToken;
    }

    protected function configure()
    {
        $this->addOption('once', 'o', InputOption::VALUE_OPTIONAL, 'if specified then will be handled only one update, not in loop');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        while(true) {
            try {
                $response = $this->client->request(Request::METHOD_GET, $this->getTelegramUri($input));
                $updateData = $this->getUpdateData($response);
                if ($updateData) {
                    foreach ($updateData['result'] as $updateData) {
                        $this->updateHandler->handle($updateData);
                        $this->updateDataRepository->saveLastUpdateId($updateData['update_id']);
                    }
                }
            } catch (GuzzleException $exception) {
                $this->logger->error($exception->getMessage());
                //sleep(10);
            }

            if ($input->getOption('once')) {
                break;
            }
        }

        return 1;
    }

    protected function getTelegramUri(InputInterface $input): string
    {
        $result = '/bot' . $this->telegramBotToken . '/getUpdates';

        $lastUpdateId = $this->updateDataRepository->getLastUpdateId();
        if ($lastUpdateId) {
            $result .= '?offset=' . ($lastUpdateId + 1);
        }
        return $result;
    }

    private function getUpdateData(ResponseInterface $response)
    {
        return json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response->getBody()), true);
    }
}
