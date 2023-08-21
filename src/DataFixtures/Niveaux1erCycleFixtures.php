<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Niveaux;
use App\Entity\Statuts;
use App\Entity\FraisScolaires;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class Niveaux1erCycleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($niv = 1; $niv <= 6; $niv++) {
            if ($niv == 1) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(2, 2));
                $niveau = new Niveaux();
                $niveau->setDesignation('1ère Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('1ère Inscription');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(1000);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut1ere_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut1ere_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut1ere_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(5000);
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
                        $this->addReference('statut1ere_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(1000);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut1ere_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(1000);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut1ere_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut1ere_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut1ere_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->addReference('niveau1er-' . $niv, $niveau);
            } elseif ($niv == 2) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(2, 2));
                $niveau = new Niveaux();
                $niveau->setDesignation('2ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut2eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut2eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut2eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(5000);
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
                        $this->addReference('statut2eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(1000);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut2eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(1000);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut2eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut2eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut2eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->addReference('niveau2eme-' . $niv, $niveau);
            } elseif ($niv == 3) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(2, 2));
                $niveau = new Niveaux();
                $niveau->setDesignation('3ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut3eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut3eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut3eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(5000);
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
                        $this->addReference('statut3eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut3eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut3eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut3eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut3eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->addReference('niveau3eme-' . $niv, $niveau);
            } elseif ($niv == 4) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(2, 2));
                $niveau = new Niveaux();
                $niveau->setDesignation('4ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut4eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut4eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut4eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(5000);
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
                        $this->addReference('statut4eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut4eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut4eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut4eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut4eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->addReference('niveau4eme-' . $niv, $niveau);
            } elseif ($niv == 5) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(2, 2));
                $niveau = new Niveaux();
                $niveau->setDesignation('5ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut5eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut5eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut5eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(5000);
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
                        $this->addReference('statut5eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut5eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut5eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut5eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut5eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->addReference('niveau5eme-' . $niv, $niveau);
            } else {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(2, 2));
                $niveau = new Niveaux();
                $niveau->setDesignation('6ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut6eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut6eme_' . $i, $statut);
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
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut6eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(5000);
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
                        $this->addReference('statut6eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Sans dossier');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut6eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(5000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(10000);
                            $frais->setNovembre(10000);
                            $frais->setDecembre(10000);
                            $frais->setJanvier(10000);
                            $frais->setFevrier(10000);
                            $frais->setMars(10000);
                            $frais->setAvril(5000);
                            $frais->setMai(0);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut6eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut6eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut6eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->addReference('niveau6eme-' . $niv, $niveau);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NiveauxMaternelleFixtures::class,
        ];
    }
}
