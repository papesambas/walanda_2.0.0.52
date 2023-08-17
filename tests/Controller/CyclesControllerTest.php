<?php

namespace App\Test\Controller;

use App\Entity\Cycles;
use App\Entity\Enseignements;
use App\Repository\CyclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CyclesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CyclesRepository $repository;
    private string $path = '/cycles/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Cycles::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $path = '/cycles/'; // Assurez-vous que $this->path contient le bon chemin

        $crawler = $this->client->request('GET', $path);

        self::assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Cycles index'); // Correction de la chaîne attendue

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
            'cycle[designation]' => 'Testing',
            'cycle[createdAt]' => 'Testing',
            'cycle[updatedAt]' => 'Testing',
            'cycle[slug]' => 'Testing',
            'cycle[enseignement]' => 'Testing',
        ]);

        self::assertResponseRedirects('/cycles/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $enseignement = new Enseignements();
        $this->markTestIncomplete();
        $fixture = new Cycles();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setEnseignement($enseignement);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cycle');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $enseignement = new Enseignements();
        $this->markTestIncomplete();
        $fixture = new Cycles();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setEnseignement($enseignement);

        $this->manager->persist($fixture);
        $this->manager->flush();;

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cycle[designation]' => 'Something New',
            'cycle[createdAt]' => 'Something New',
            'cycle[updatedAt]' => 'Something New',
            'cycle[slug]' => 'Something New',
            'cycle[enseignement]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cycles/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getEnseignement());
    }

    public function testRemove(): void
    {
        $enseignement = new Enseignements();
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Cycles();
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setEnseignement($enseignement);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/cycles/');
    }
}
