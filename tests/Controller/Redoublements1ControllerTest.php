<?php

namespace App\Test\Controller;

use App\Entity\Redoublements1;
use App\Repository\Redoublements1Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Redoublements1ControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private Redoublements1Repository $repository;
    private string $path = '/redoublements1/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Redoublements1::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Redoublements1 index');

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
            'redoublements1[niveau]' => 'Testing',
            'redoublements1[scolarite1]' => 'Testing',
            'redoublements1[scolarite2]' => 'Testing',
            'redoublements1[scolarite3]' => 'Testing',
        ]);

        self::assertResponseRedirects('/redoublements1/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Redoublements1();
        $fixture->setNiveau('My Title');
        $fixture->setScolarite1('My Title');
        $fixture->setScolarite2('My Title');
        $fixture->setScolarite3('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Redoublements1');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Redoublements1();
        $fixture->setNiveau('My Title');
        $fixture->setScolarite1('My Title');
        $fixture->setScolarite2('My Title');
        $fixture->setScolarite3('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'redoublements1[niveau]' => 'Something New',
            'redoublements1[scolarite1]' => 'Something New',
            'redoublements1[scolarite2]' => 'Something New',
            'redoublements1[scolarite3]' => 'Something New',
        ]);

        self::assertResponseRedirects('/redoublements1/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNiveau());
        self::assertSame('Something New', $fixture[0]->getScolarite1());
        self::assertSame('Something New', $fixture[0]->getScolarite2());
        self::assertSame('Something New', $fixture[0]->getScolarite3());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Redoublements1();
        $fixture->setNiveau('My Title');
        $fixture->setScolarite1('My Title');
        $fixture->setScolarite2('My Title');
        $fixture->setScolarite3('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/redoublements1/');
    }
}
