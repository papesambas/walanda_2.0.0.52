<?php

namespace App\Test\Controller;

use App\Entity\Enseignements;
use App\Entity\Etablissements;
use App\Repository\EnseignementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EnseignementsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EnseignementsRepository $repository;
    private string $path = '/enseignements/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Enseignements::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $path = '/enseignements/'; // Assurez-vous que $this->path contient le bon chemin

        $crawler = $this->client->request('GET', $path);

        self::assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Enseignements index'); // Correction de la chaîne attendue

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p'
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'enseignement[designation]' => 'Testing',
            'enseignement[createdAt]' => 'Testing',
            'enseignement[updatedAt]' => 'Testing',
            'enseignement[slug]' => 'Testing',
            'enseignement[etablissement]' => 'Testing',
        ]);

        self::assertResponseRedirects('/enseignements/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $etablissement = new Etablissements();
        $this->markTestIncomplete();
        $fixture = new Enseignements();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setEtablissement($etablissement);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Enseignement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $etablissement = new Etablissements();
        $this->markTestIncomplete();
        $fixture = new Enseignements();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setEtablissement($etablissement);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'enseignement[designation]' => 'Something New',
            'enseignement[createdAt]' => 'Something New',
            'enseignement[updatedAt]' => 'Something New',
            'enseignement[slug]' => 'Something New',
            'enseignement[etablissement]' => 'Something New',
        ]);

        self::assertResponseRedirects('/enseignements/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getEtablissement());
    }

    public function testRemove(): void
    {
        $etablissement = new Etablissements();
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Enseignements();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setEtablissement($etablissement);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/enseignements/');
    }
}
