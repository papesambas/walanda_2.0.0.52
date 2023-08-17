<?php

namespace App\Test\Controller;

use App\Entity\Meres;
use App\Entity\Parents;
use App\Entity\Peres;
use App\Repository\ParentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ParentsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ParentsRepository $repository;
    private string $path = '/parents/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Parents::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $path = '/parents/'; // Assurez-vous que $this->path contient le bon chemin

        $crawler = $this->client->request('GET', $path);

        self::assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Parents index'); // Correction de la chaîne attendue

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
            'parent[createdAt]' => 'Testing',
            'parent[updatedAt]' => 'Testing',
            'parent[pere]' => 'Testing',
            'parent[mere]' => 'Testing',
        ]);

        self::assertResponseRedirects('/parents/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $pere = new Peres();
        $mere = new Meres();
        $this->markTestIncomplete();
        $fixture = new Parents();
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setPere($pere);
        $fixture->setMere($mere);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Parent');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $pere = new Peres();
        $mere = new Meres();
        $this->markTestIncomplete();
        $fixture = new Parents();
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setPere($pere);
        $fixture->setMere($mere);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'parent[createdAt]' => 'Something New',
            'parent[updatedAt]' => 'Something New',
            'parent[pere]' => 'Something New',
            'parent[mere]' => 'Something New',
        ]);

        self::assertResponseRedirects('/parents/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getPere());
        self::assertSame('Something New', $fixture[0]->getMere());
    }

    public function testRemove(): void
    {
        $pere = new Peres();
        $mere = new Meres();
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Parents();
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setPere($pere);
        $fixture->setMere($mere);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/parents/');
    }
}
