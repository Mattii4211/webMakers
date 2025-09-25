<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Finance\Domain\Entity\Contractor;
use App\Finance\Domain\Entity\Invoice;
use App\Finance\Domain\Entity\Budget;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 10) as $i) {
            $contractor = new Contractor('Contractor ' . $i);
            $manager->persist($contractor);

            $invoice = new Invoice($contractor, 'INV-' . str_pad((string)$i, 4, '0', STR_PAD_LEFT), 100 + $i * 10, new DateTime("+$i days"));
            $manager->persist($invoice);

            $budget = new Budget('Budget-' . str_pad((string)$i, 4, '0', STR_PAD_LEFT), rand(0, 2000));
            $manager->persist($budget);
        }

        $manager->flush();

        $contractor = $manager->getRepository(Contractor::class)->findAll()[0];
        $manager->persist(new Invoice($contractor, 'Test_test1', 100, new DateTime("-1 days")));
        $manager->persist(new Invoice($contractor, 'Test_test2', 15000, new DateTime("-10 days")));

        $manager->persist(new Budget('Budget-Test_1', -100));
        $manager->persist(new Budget('Budget-Test_2', balance: -500));

        $manager->flush();
    }
}
