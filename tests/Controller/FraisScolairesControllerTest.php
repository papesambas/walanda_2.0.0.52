<?php

namespace App\Test\Controller;

use App\Entity\FraisScolaires;
use App\Repository\FraisScolairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FraisScolairesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FraisScolairesRepository $repository;
    private string $path = '/frais/scolaires/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(FraisScolaires::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('FraisScolaire index');

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
            'frais_scolaire[designation]' => 'Testing',
            'frais_scolaire[montant]' => 'Testing',
            'frais_scolaire[createdAt]' => 'Testing',
            'frais_scolaire[updatedAt]' => 'Testing',
            'frais_scolaire[statut]' => 'Testing',
            'frais_scolaire[niveau]' => 'Testing',
            'frais_scolaire[echeance]' => 'Testing',
        ]);

        self::assertResponseRedirects('/frais/scolaires/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new FraisScolaires();
        $fixture->setDesignation('My Title');
        $fixture->setMontant('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setStatut('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setEcheance('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('FraisScolaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new FraisScolaires();
        $fixture->setDesignation('My Title');
        $fixture->setMontant('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setStatut('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setEcheance('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'frais_scolaire[designation]' => 'Something New',
            'frais_scolaire[montant]' => 'Something New',
            'frais_scolaire[createdAt]' => 'Something New',
            'frais_scolaire[updatedAt]' => 'Something New',
            'frais_scolaire[statut]' => 'Something New',
            'frais_scolaire[niveau]' => 'Something New',
            'frais_scolaire[echeance]' => 'Something New',
        ]);

        self::assertResponseRedirects('/frais/scolaires/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getStatut());
        self::assertSame('Something New', $fixture[0]->getNiveau());
        self::assertSame('Something New', $fixture[0]->getEcheance());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new FraisScolaires();
        $fixture->setDesignation('My Title');
        $fixture->setMontant('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setStatut('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setEcheance('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/frais/scolaires/');
    }
}
