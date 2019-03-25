<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 25.03.19
 * Time: 15:01
 */

namespace App\Command;

use App\Service\IntegralCalculator;
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

    /**
     * AqiCalculateCommand constructor.
     * @param IntegralCalculator $indexCalculator
     */
    public function __construct(IntegralCalculator $indexCalculator)
    {
        $this->indexCalculator = $indexCalculator;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('background:calculateAqi');
        $this->setDescription('This command calculates AQI for last measures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->indexCalculator->calculateAqiList();
    }
}
