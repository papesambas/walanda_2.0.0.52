<?php

namespace App\Test\Controller;

use App\Entity\FraisScolarites;
use App\Repository\FraisScolaritesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FraisScolaritesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FraisScolaritesRepository $repository;
    private string $path = '/frais/scolarites/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(FraisScolarites::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('FraisScolarite index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'frais_scolarite[montant]' => 'Testing',
            'frais_scolarite[eleve]' => 'Testing',
            'frais_scolarite[fraisType]' => 'Testing',
        ]);

        self::assertResponseRedirects('/frais/scolarites/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new FraisScolarites();
        $fixture->setMontant('My Title');
        $fixture->setEleve('My Title');
        $fixture->setFraisType('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('FraisScolarite');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new FraisScolarites();
        $fixture->setMontant('My Title');
        $fixture->setEleve('My Title');
        $fixture->setFraisType('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'frais_scolarite[montant]' => 'Something New',
            'frais_scolarite[eleve]' => 'Something New',
            'frais_scolarite[fraisType]' => 'Something New',
        ]);

        self::assertResponseRedirects('/frais/scolarites/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getEleve());
        self::assertSame('Something New', $fixture[0]->getFraisType());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new FraisScolarites();
        $fixture->setMontant('My Title');
        $fixture->setEleve('My Title');
        $fixture->setFraisType('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/frais/scolarites/');
    }
}
