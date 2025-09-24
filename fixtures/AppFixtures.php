<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Finance\Domain\Entity\Contractor;
use App\Finance\Domain\Entity\Invoice;
use App\Finance\Domain\Entity\Budget;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $manager->flush();
    }
}
