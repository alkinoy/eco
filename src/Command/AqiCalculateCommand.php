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
use Symfony\Component\Console\Input\InputArgument;
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

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('background:calculateAqi');
        $this->setDescription('This command calculates AQI for last measures');
        $this->addArgument('dateFrom', InputArgument::OPTIONAL);
        $this->addArgument('dateTo', InputArgument::OPTIONAL);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dateFrom = $input->getArgument('dateFrom') ?? 'now';
        $dateFrom = new \DateTime((new \DateTime($dateFrom))->format('Y-m-d H:00'));

        $dateTo = $input->getArgument('dateTo') ?? 'now';
        $dateTo = new \DateTime((new \DateTime($dateTo))->format('Y-m-d H:i'));

        $output->writeln(date('Y-m-d H:i:s').' Start calculate AQI...');
        $this->logger->info('Start calculate AQI');
        while($dateFrom <= $dateTo) {
            $this->indexCalculator->calculateAqiList($dateFrom);
            $output->writeln('...'.$dateFrom->format('Y-m-d H:i').' was done!');
            $dateFrom->add(new \DateInterval('PT1H'));
        }
        $this->logger->info('AQI calculation done');
        $output->writeln('done!');
    }
}
