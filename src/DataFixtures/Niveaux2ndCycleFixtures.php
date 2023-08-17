<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Niveaux;
use App\Entity\Statuts;
use App\Entity\FraisScolaires;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class Niveaux2ndCycleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($niv = 1; $niv <= 3; $niv++) {
            if ($niv == 1) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(3, 3));
                $niveau = new Niveaux();
                $niveau->setDesignation('7ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(10000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    } elseif ($i == 2) {
                        $statut = new Statuts();
                        $statut->setDesignation('Passant');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    } elseif ($i == 3) {
                        $statut = new Statuts();
                        $statut->setDesignation('Redoublant');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(15000);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(0);
                            $frais->setNovembre(0);
                            $frais->setDecembre(0);
                            $frais->setJanvier(0);
                            $frais->setFevrier(0);
                            $frais->setMars(0);
                            $frais->setAvril(0);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(10000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(10000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut7eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->setReference('niveau7eme-' . $niv, $niveau);
            } elseif ($niv == 2) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(3, 3));
                $niveau = new Niveaux();
                $niveau->setDesignation('8ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(10000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    } elseif ($i == 2) {
                        $statut = new Statuts();
                        $statut->setDesignation('Passant');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    } elseif ($i == 3) {
                        $statut = new Statuts();
                        $statut->setDesignation('Redoublant');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(15000);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(0);
                            $frais->setNovembre(0);
                            $frais->setDecembre(0);
                            $frais->setJanvier(0);
                            $frais->setFevrier(0);
                            $frais->setMars(0);
                            $frais->setAvril(0);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(10000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(10000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(20000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(15000);
                            $frais->setFevrier(10000);
                            $frais->setMars(15000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut8eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->setReference('niveau8eme-' . $niv, $niveau);
            } else {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(3, 3));
                $niveau = new Niveaux();
                $niveau->setDesignation('9ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 9; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(25000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(25000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(20000);
                            $frais->setFevrier(10000);
                            $frais->setMars(20000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 2) {
                        $statut = new Statuts();
                        $statut->setDesignation('Passant');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(25000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(20000);
                            $frais->setFevrier(10000);
                            $frais->setMars(20000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 3) {
                        $statut = new Statuts();
                        $statut->setDesignation('Redoublant');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(25000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(20000);
                            $frais->setFevrier(10000);
                            $frais->setMars(20000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(15000);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(0);
                            $frais->setNovembre(0);
                            $frais->setDecembre(0);
                            $frais->setJanvier(0);
                            $frais->setFevrier(0);
                            $frais->setMars(0);
                            $frais->setAvril(0);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Candidat libre');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(25000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(25000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(20000);
                            $frais->setFevrier(10000);
                            $frais->setMars(20000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(25000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(25000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(20000);
                            $frais->setFevrier(10000);
                            $frais->setMars(20000);
                            $frais->setAvril(10000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    } elseif ($i == 9) {
                        $statut = new Statuts();
                        $statut->setDesignation('Passe au D.E.F.');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut9eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->setReference('niveau9eme-' . $niv, $niveau);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            Niveaux1erCycleFixtures::class,
        ];
    }
}
