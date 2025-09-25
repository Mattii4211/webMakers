<?php

declare(strict_types=1);

namespace App\Core\Application\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Core\Application\Service\GenerateWarningsHandler;
use App\Core\Domain\Entity\Warning;

#[AsCommand(name: 'app:warnings:generate')]
final class GenerateWarningsCommand extends Command
{
    public function __construct(
        private GenerateWarningsHandler $generateWarningsHandler,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
        $this->generateWarningsHandler = $generateWarningsHandler;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Generuje ostrzeżenia dla wszystkich typów obiektów.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $warnings = $this->generateWarningsHandler->generate();
        $currentWarnings = $this->entityManager->getRepository(Warning::class)->findAll();

        foreach ($warnings as $warning) {
            $output->writeln(sprintf(
                'Wygenerowano ostrzeżenie: [%s] Obiekt: %s (ID: %d) - %s',
                $warning->getId()->toString(),
                $warning->getObjectType(),
                $warning->getObjectId(),
                $warning->getCategory()
            ));
        }

        return Command::SUCCESS;
    }
}
