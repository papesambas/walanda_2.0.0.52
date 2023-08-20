<?php

namespace App\Test\Controller;

use App\Entity\Departs;
use App\Repository\DepartsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepartsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private DepartsRepository $repository;
    private string $path = '/departs/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Departs::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Depart index');

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
            'depart[dateDepart]' => 'Testing',
            'depart[motif]' => 'Testing',
            'depart[ecoleDestination]' => 'Testing',
            'depart[createdAt]' => 'Testing',
            'depart[updatedAt]' => 'Testing',
            'depart[eleve]' => 'Testing',
        ]);

        self::assertResponseRedirects('/departs/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Departs();
        $fixture->setDateDepart('My Title');
        $fixture->setMotif('My Title');
        $fixture->setEcoleDestination('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Depart');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Departs();
        $fixture->setDateDepart('My Title');
        $fixture->setMotif('My Title');
        $fixture->setEcoleDestination('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'depart[dateDepart]' => 'Something New',
            'depart[motif]' => 'Something New',
            'depart[ecoleDestination]' => 'Something New',
            'depart[createdAt]' => 'Something New',
            'depart[updatedAt]' => 'Something New',
            'depart[eleve]' => 'Something New',
        ]);

        self::assertResponseRedirects('/departs/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateDepart());
        self::assertSame('Something New', $fixture[0]->getMotif());
        self::assertSame('Something New', $fixture[0]->getEcoleDestination());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getEleve());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Departs();
        $fixture->setDateDepart('My Title');
        $fixture->setMotif('My Title');
        $fixture->setEcoleDestination('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/departs/');
    }
}
