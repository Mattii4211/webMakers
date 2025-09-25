<?php

declare(strict_types=1);

namespace App\Core\Application\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Core\Application\Service\GenerateWarningsHandler;
use App\Core\Domain\Entity\Warning;
use App\Core\Domain\Repository\WarningRepositoryInterface;
use DateTime;

#[AsCommand(name: 'app:warnings:generate')]
final class GenerateWarningsCommand extends Command
{
    public function __construct(
        private GenerateWarningsHandler $generateWarningsHandler,
        private WarningRepositoryInterface $warningRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Generuje ostrzeżenia dla wszystkich typów obiektów.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $resultsArray = $currentWarningsArray = [];
        $runCommandDate = new DateTime();
        $warnings = $this->generateWarningsHandler->generate();
        $currentWarnings = $this->warningRepository->findAllNotClosed($runCommandDate);

        if (count($currentWarnings) > 0) {
            foreach ($currentWarnings as $warning) {
                $this->warningRepository->setDeleted($warning);

                if (!isset($currentWarningsArray[$warning->getCategory()])) {
                    $currentWarningsArray[$warning->getCategory()] = 1;
                } else {
                    $currentWarningsArray[$warning->getCategory()]++;
                }
            }
        }

        foreach ($warnings as $warning) {
            if (!isset($resultsArray[$warning->getCategory()])) {
                $resultsArray[$warning->getCategory()] = ['inserted' => 0, 'updated' => 0];
            }

            $resultsArray[$warning->getCategory()][$this->warningRepository->save($warning)->value]++;
        }

        $output->writeln('================================');
        $output->writeln('Podsumowanie wygenerowanych ostrzeżeń:');

        foreach ($resultsArray as $category => $results) {
            $inserted = $results['inserted'];
            $updated = $results['updated'];
            $output->writeln(sprintf(
                'Kategoria: %s - Nowe: %d, Zaktualizowane: %d, Zamknięte: %d',
                $category,
                $inserted,
                $updated,
                $currentWarningsArray[$category] ?? 0,
            ));
        }

        $output->writeln('================================');

        return Command::SUCCESS;
    }
}
