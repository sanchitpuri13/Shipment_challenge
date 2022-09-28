<?php

namespace App\Command;

use App\Service\Helper\HelperInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use App\Service\Transaction\TransactionInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportShipmentsCommand extends Command
{
    protected static $defaultName = 'app:import:shipments';
    protected static $defaultDescription = 'Import shipments from json file to database';

    private ParameterBagInterface $paramBag;
    private HelperInterface $helperService;
    private TransactionInterface $databaseTransaction;

    /**
     * Constructor
     *
     * @param ParameterBagInterface $paramBag
     * @param HelperInterface $helperService
     * @param TransactionInterface $databaseTransaction
     */
    public function __construct(ParameterBagInterface $paramBag, HelperInterface $helperService, TransactionInterface $databaseTransaction)
    {
        $this->paramBag = $paramBag;
        $this->helperService = $helperService;
        $this->databaseTransaction = $databaseTransaction;
        parent::__construct();
    }

    /**
     * Function to configure command arguments and options
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addArgument('source', InputArgument::OPTIONAL, 'Shipment Source')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * Function is responsible for executing the process when the command is executed
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('source');

        $shipmentDataFile = $this->paramBag->get('import_file_dir') . $this->paramBag->get('import_file');

        $shipments = $this->helperService->convertFileDataIntoArray($shipmentDataFile);

        $companies = $this->helperService->getCompanyDataFromShipments($shipments);

        $carriers = $this->helperService->getCarriersDataFromShipments($shipments);

        $shipmentsData = $this->helperService->getShipmentsData($shipments);

        $progressBar = new ProgressBar($output, count($companies));

        $progressBar->setBarCharacter('<fg=green>•</>');
        $progressBar->setEmptyBarCharacter('<fg=green>⚬</>');
        $progressBar->setProgressCharacter('<fg=green>➤</>');

        $io->success('Company Import Started');
        $progressBar->start();
        $this->databaseTransaction->createCompany($companies, $progressBar);
        $progressBar->finish();
        $io->success('Company Import Finished');

        $progressBar->setMaxSteps(count($carriers));
        $io->success('Carrier Import Started');
        $progressBar->start();
        $this->databaseTransaction->createCarrier($carriers, $progressBar);
        $progressBar->finish();
        $io->success('Carrier Import Finished');

        $progressBar->setMaxSteps(count($shipments));

        $io->success('Shipments Import Started');
        $progressBar->start();
        $this->databaseTransaction->createShipment($shipmentsData, $progressBar);
        $progressBar->finish();
        $io->success('Shipments Import Finished');

        $io->success('Shipments Imported Sucessfully');

        return Command::SUCCESS;
    }
}
