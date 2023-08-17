<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Niveaux;
use App\Entity\Statuts;
use App\Entity\FraisScolaires;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class Niveaux3ndCycleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($niv = 1; $niv <= 3; $niv++) {
            if ($niv == 1) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(4, 4));
                $niveau = new Niveaux();
                $niveau->setDesignation('10ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(50000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
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
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
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
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(30000);
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
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Candidat libre');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(50000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(50000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut10eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->setReference('niveau10eme-' . $niv, $niveau);
            } elseif ($niv == 2) {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(4, 4));
                $niveau = new Niveaux();
                $niveau->setDesignation('11ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(50000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
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
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
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
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(30000);
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
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Candidat libre');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(50000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(50000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut11eme_' . $i, $statut);
                    }
                }
                $manager->persist($niveau);
                $this->setReference('niveau11eme-' . $niv, $niveau);
            } else {
                $cycle = $this->getReference('cycle-' . $faker->numberBetween(4, 4));
                $niveau = new Niveaux();
                $niveau->setDesignation('12ème Année');
                $niveau->setCycle($cycle);
                for ($i = 1; $i <= 9; $i++) {
                    if ($i == 1) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert Arrivé');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(100000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
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
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
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
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
                    } elseif ($i == 4) {
                        $statut = new Statuts();
                        $statut->setDesignation('Transfert départ');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(0);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(30000);
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
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
                    } elseif ($i == 5) {
                        $statut = new Statuts();
                        $statut->setDesignation('Candidat libre');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(100000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
                    } elseif ($i == 6) {
                        $statut = new Statuts();
                        $statut->setDesignation('En attente');
                        $statut->setNiveau($niveau);
                        for ($a = 1; $a <= 1; $a++) {
                            $frais = new FraisScolaires();
                            $frais->setAutres(0);
                            $frais->setFraisInscription(100000);
                            $frais->setFraisCarnet(0);
                            $frais->setFraisTransfert(0);
                            $frais->setSeptembre(0);
                            $frais->setOctobre(40000);
                            $frais->setNovembre(30000);
                            $frais->setDecembre(30000);
                            $frais->setJanvier(30000);
                            $frais->setFevrier(30000);
                            $frais->setMars(30000);
                            $frais->setAvril(30000);
                            $frais->setMai(30000);
                            $frais->setJuin(0);
                            $frais->setNiveau($niveau);
                            $frais->setStatut($statut);
                            $frais->setAutres(35000);
                            $manager->persist($frais);
                        }
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
                    } elseif ($i == 7) {
                        $statut = new Statuts();
                        $statut->setDesignation('Abandon');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
                    } elseif ($i == 8) {
                        $statut = new Statuts();
                        $statut->setDesignation('Exclus');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
                    } elseif ($i == 9) {
                        $statut = new Statuts();
                        $statut->setDesignation('Passe au BAC');
                        $statut->setNiveau($niveau);
                        $manager->persist($statut);
                        $this->addReference('statut12eme_' . $i, $statut);
                    }
                }

                $manager->persist($niveau);
                $this->setReference('niveau12eme-' . $niv, $niveau);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            Niveaux2ndCycleFixtures::class,
        ];
    }
}
