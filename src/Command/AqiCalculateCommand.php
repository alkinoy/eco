<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 25.03.19
 * Time: 15:01
 */

namespace App\Command;

use App\Service\IntegralCalculator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AqiCalculateCommand
 * @package App\Command
 */
class AqiCalculateCommand extends Command
{
    /** @var IntegralCalculator */
    protected $indexCalculator;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * AqiCalculateCommand constructor.
     * @param IntegralCalculator $indexCalculator
     * @param LoggerInterface $logger
     */
    public function __construct(IntegralCalculator $indexCalculator, LoggerInterface $logger)
    {
        $this->indexCalculator = $indexCalculator;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this->setName('background:calculateAqi');
        $this->setDescription('This command calculates AQI for last measures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write(date('Y-m-d H:i:s').' Start calculate AQI...');
        $this->logger->info('Start calculate AQI');
        $this->indexCalculator->calculateAqiList();
        $this->logger->info('AQI calculation done');
        $output->writeln('done!');
    }
}
