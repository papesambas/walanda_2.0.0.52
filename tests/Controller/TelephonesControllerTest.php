<?php

namespace App\Test\Controller;

use App\Entity\Meres;
use App\Entity\Peres;
use App\Entity\Telephones;
use App\Repository\TelephonesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TelephonesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TelephonesRepository $repository;
    private string $path = '/telephones/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Telephones::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $path = '/telephones/'; // Assurez-vous que $this->path contient le bon chemin

        $crawler = $this->client->request('GET', $path);

        self::assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Telephones index'); // Correction de la chaîne attendue

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
            'telephone[numero]' => 'Testing',
            'telephone[createdAt]' => 'Testing',
            'telephone[updatedAt]' => 'Testing',
            'telephone[slug]' => 'Testing',
            'telephone[peres]' => 'Testing',
            'telephone[meres]' => 'Testing',
        ]);

        self::assertResponseRedirects('/telephones/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $pere = new Peres();
        $mere = new Meres();
        $this->markTestIncomplete();
        $fixture = new Telephones();
        $fixture->setNumero('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setPeres($pere);
        $fixture->setMeres($mere);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Telephone');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $pere = new Peres();
        $mere = new Meres();
        $this->markTestIncomplete();
        $fixture = new Telephones();
        $fixture->setNumero('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setPeres($pere);
        $fixture->setMeres($mere);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'telephone[numero]' => 'Something New',
            'telephone[createdAt]' => 'Something New',
            'telephone[updatedAt]' => 'Something New',
            'telephone[slug]' => 'Something New',
            'telephone[peres]' => 'Something New',
            'telephone[meres]' => 'Something New',
        ]);

        self::assertResponseRedirects('/telephones/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNumero());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getPeres());
        self::assertSame('Something New', $fixture[0]->getMeres());
    }

    public function testRemove(): void
    {
        $pere = new Peres();
        $mere = new Meres();
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Telephones();
        $fixture->setNumero('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setPeres($pere);
        $fixture->setMeres($mere);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/telephones/');
    }
}