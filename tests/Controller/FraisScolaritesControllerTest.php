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
            'frais_scolarite[inscription]' => 'Testing',
            'frais_scolarite[carnet]' => 'Testing',
            'frais_scolarite[transfert]' => 'Testing',
            'frais_scolarite[septembre]' => 'Testing',
            'frais_scolarite[octobre]' => 'Testing',
            'frais_scolarite[novembre]' => 'Testing',
            'frais_scolarite[decembre]' => 'Testing',
            'frais_scolarite[janvier]' => 'Testing',
            'frais_scolarite[fevrier]' => 'Testing',
            'frais_scolarite[mars]' => 'Testing',
            'frais_scolarite[avril]' => 'Testing',
            'frais_scolarite[mai]' => 'Testing',
            'frais_scolarite[juin]' => 'Testing',
            'frais_scolarite[autre]' => 'Testing',
            'frais_scolarite[eleve]' => 'Testing',
        ]);

        self::assertResponseRedirects('/frais/scolarites/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new FraisScolarites();
        $fixture->setInscription('My Title');
        $fixture->setCarnet('My Title');
        $fixture->setTransfert('My Title');
        $fixture->setSeptembre('My Title');
        $fixture->setOctobre('My Title');
        $fixture->setNovembre('My Title');
        $fixture->setDecembre('My Title');
        $fixture->setJanvier('My Title');
        $fixture->setFevrier('My Title');
        $fixture->setMars('My Title');
        $fixture->setAvril('My Title');
        $fixture->setMai('My Title');
        $fixture->setJuin('My Title');
        $fixture->setAutre('My Title');
        $fixture->setEleve('My Title');

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
        $fixture->setInscription('My Title');
        $fixture->setCarnet('My Title');
        $fixture->setTransfert('My Title');
        $fixture->setSeptembre('My Title');
        $fixture->setOctobre('My Title');
        $fixture->setNovembre('My Title');
        $fixture->setDecembre('My Title');
        $fixture->setJanvier('My Title');
        $fixture->setFevrier('My Title');
        $fixture->setMars('My Title');
        $fixture->setAvril('My Title');
        $fixture->setMai('My Title');
        $fixture->setJuin('My Title');
        $fixture->setAutre('My Title');
        $fixture->setEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'frais_scolarite[inscription]' => 'Something New',
            'frais_scolarite[carnet]' => 'Something New',
            'frais_scolarite[transfert]' => 'Something New',
            'frais_scolarite[septembre]' => 'Something New',
            'frais_scolarite[octobre]' => 'Something New',
            'frais_scolarite[novembre]' => 'Something New',
            'frais_scolarite[decembre]' => 'Something New',
            'frais_scolarite[janvier]' => 'Something New',
            'frais_scolarite[fevrier]' => 'Something New',
            'frais_scolarite[mars]' => 'Something New',
            'frais_scolarite[avril]' => 'Something New',
            'frais_scolarite[mai]' => 'Something New',
            'frais_scolarite[juin]' => 'Something New',
            'frais_scolarite[autre]' => 'Something New',
            'frais_scolarite[eleve]' => 'Something New',
        ]);

        self::assertResponseRedirects('/frais/scolarites/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getInscription());
        self::assertSame('Something New', $fixture[0]->getCarnet());
        self::assertSame('Something New', $fixture[0]->getTransfert());
        self::assertSame('Something New', $fixture[0]->getSeptembre());
        self::assertSame('Something New', $fixture[0]->getOctobre());
        self::assertSame('Something New', $fixture[0]->getNovembre());
        self::assertSame('Something New', $fixture[0]->getDecembre());
        self::assertSame('Something New', $fixture[0]->getJanvier());
        self::assertSame('Something New', $fixture[0]->getFevrier());
        self::assertSame('Something New', $fixture[0]->getMars());
        self::assertSame('Something New', $fixture[0]->getAvril());
        self::assertSame('Something New', $fixture[0]->getMai());
        self::assertSame('Something New', $fixture[0]->getJuin());
        self::assertSame('Something New', $fixture[0]->getAutre());
        self::assertSame('Something New', $fixture[0]->getEleve());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new FraisScolarites();
        $fixture->setInscription('My Title');
        $fixture->setCarnet('My Title');
        $fixture->setTransfert('My Title');
        $fixture->setSeptembre('My Title');
        $fixture->setOctobre('My Title');
        $fixture->setNovembre('My Title');
        $fixture->setDecembre('My Title');
        $fixture->setJanvier('My Title');
        $fixture->setFevrier('My Title');
        $fixture->setMars('My Title');
        $fixture->setAvril('My Title');
        $fixture->setMai('My Title');
        $fixture->setJuin('My Title');
        $fixture->setAutre('My Title');
        $fixture->setEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/frais/scolarites/');
    }
}
