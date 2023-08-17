<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Echeances;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EcheancesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $dateCourante = new \DateTime();
        $anneeCourante = $dateCourante->format('Y');
        $dateDepart = new \DateTime($anneeCourante . '-08-01');

        // Nombre d'échéances
        $nombreEcheances = 9;

        // Liste pour stocker les dates d'échéance
        $listeEcheances = [];

        for ($i = 0; $i < $nombreEcheances; $i++) {
            // Ajouter un mois à la date de départ
            $dateEcheance = clone $dateDepart;
            $dateEcheance->add(new \DateInterval('P' . ($i + 1) . 'M'));

            // Set the day of the month for the fixed day
            $jourFixe = 05;
            $dateEcheance->setDate($dateEcheance->format('Y'), $dateEcheance->format('m'), $jourFixe);

            // Add one month and set the day of the month to the fixed day
            if ($dateEcheance <= $dateCourante) {
                $dateEcheance->add(new \DateInterval('P1M'));
                $dateEcheance->setDate($dateEcheance->format('Y'), $dateEcheance->format('m'), $jourFixe);
            }

            $echeance = new Echeances();
            $echeance->setEcheance($dateEcheance);

            $manager->persist($echeance);

            // Ajouter la date d'échéance à la liste
            $listeEcheances[] = $dateEcheance->format('Y-m-d');
        }

        // Afficher la liste des dates d'échéance
        foreach ($listeEcheances as $echeance) {
            echo $echeance . "\n";
        }

        $manager->flush();
    }
}
