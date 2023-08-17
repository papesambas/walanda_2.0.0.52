<?php

namespace App\Test\Controller;

use App\Entity\Niveaux;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use App\Entity\Scolarites3;
use App\Repository\Redoublements3Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Redoublements3ControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private Redoublements3Repository $repository;
    private string $path = '/redoublements3/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Redoublements3::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Redoublements3 index');

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
            'redoublements3[niveau]' => 'Testing',
            'redoublements3[redoublement2]' => 'Testing',
            'redoublements3[scolarite1]' => 'Testing',
            'redoublements3[scolarite2]' => 'Testing',
            'redoublements3[scolarite3]' => 'Testing',
        ]);

        self::assertResponseRedirects('/redoublements3/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $niveau = new Niveaux();
        $scolarite1 = new Scolarites1();
        $scolarite2 = new Scolarites2();
        $scolarite3 = new Scolarites3();
        $redoublement2 = new Redoublements2();

        $this->markTestIncomplete();
        $fixture = new Redoublements3();
        $fixture->setNiveau($niveau);
        $fixture->setRedoublement2($redoublement2);
        $fixture->setScolarite1($scolarite1);
        $fixture->setScolarite2($scolarite2);
        $fixture->setScolarite3($scolarite3);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Redoublements3');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $niveau = new Niveaux();
        $scolarite1 = new Scolarites1();
        $scolarite2 = new Scolarites2();
        $scolarite3 = new Scolarites3();
        $redoublement2 = new Redoublements2();

        $this->markTestIncomplete();
        $fixture = new Redoublements3();
        $fixture->setNiveau($niveau);
        $fixture->setRedoublement2($redoublement2);
        $fixture->setScolarite1($scolarite1);
        $fixture->setScolarite2($scolarite2);
        $fixture->setScolarite3($scolarite3);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'redoublements3[niveau]' => 'Something New',
            'redoublements3[redoublement2]' => 'Something New',
            'redoublements3[scolarite1]' => 'Something New',
            'redoublements3[scolarite2]' => 'Something New',
            'redoublements3[scolarite3]' => 'Something New',
        ]);

        self::assertResponseRedirects('/redoublements3/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNiveau());
        self::assertSame('Something New', $fixture[0]->getRedoublement2());
        self::assertSame('Something New', $fixture[0]->getScolarite1());
        self::assertSame('Something New', $fixture[0]->getScolarite2());
        self::assertSame('Something New', $fixture[0]->getScolarite3());
    }

    public function testRemove(): void
    {
        $niveau = new Niveaux();
        $scolarite1 = new Scolarites1();
        $scolarite2 = new Scolarites2();
        $scolarite3 = new Scolarites3();
        $redoublement2 = new Redoublements2();

        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Redoublements3();
        $fixture->setNiveau($niveau);
        $fixture->setRedoublement2($redoublement2);
        $fixture->setScolarite1($scolarite1);
        $fixture->setScolarite2($scolarite2);
        $fixture->setScolarite3($scolarite3);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/redoublements3/');
    }
}
