<?php

namespace App\Test\Controller;

use App\Entity\Cycles;
use App\Entity\Niveaux;
use App\Repository\NiveauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NiveauxControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private NiveauxRepository $repository;
    private string $path = '/niveaux/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Niveaux::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $path = '/niveaux/'; // Assurez-vous que $this->path contient le bon chemin

        $crawler = $this->client->request('GET', $path);

        self::assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Niveaux index'); // Correction de la chaîne attendue

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
            'niveau[designation]' => 'Testing',
            'niveau[createdAt]' => 'Testing',
            'niveau[updatedAt]' => 'Testing',
            'niveau[slug]' => 'Testing',
            'niveau[cycle]' => 'Testing',
        ]);

        self::assertResponseRedirects('/niveaux/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $cycle = new Cycles();
        $this->markTestIncomplete();
        $fixture = new Niveaux();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setCycle($cycle);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Niveau');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $cycle = new Cycles();
        $this->markTestIncomplete();
        $fixture = new Niveaux();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setCycle($cycle);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'niveau[designation]' => 'Something New',
            'niveau[createdAt]' => 'Something New',
            'niveau[updatedAt]' => 'Something New',
            'niveau[slug]' => 'Something New',
            'niveau[cycle]' => 'Something New',
        ]);

        self::assertResponseRedirects('/niveaux/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getCycle());
    }

    public function testRemove(): void
    {
        $cycle = new Cycles();
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Niveaux();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setCycle($cycle);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/niveaux/');
    }
}
