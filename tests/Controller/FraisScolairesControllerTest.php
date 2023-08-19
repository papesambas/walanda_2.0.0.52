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
            'frais_scolaire[fraisInscription]' => 'Testing',
            'frais_scolaire[fraisCarnet]' => 'Testing',
            'frais_scolaire[fraisTransfert]' => 'Testing',
            'frais_scolaire[septembre]' => 'Testing',
            'frais_scolaire[octobre]' => 'Testing',
            'frais_scolaire[novembre]' => 'Testing',
            'frais_scolaire[decembre]' => 'Testing',
            'frais_scolaire[janvier]' => 'Testing',
            'frais_scolaire[fevrier]' => 'Testing',
            'frais_scolaire[mars]' => 'Testing',
            'frais_scolaire[avril]' => 'Testing',
            'frais_scolaire[mai]' => 'Testing',
            'frais_scolaire[juin]' => 'Testing',
            'frais_scolaire[autres]' => 'Testing',
            'frais_scolaire[createdAt]' => 'Testing',
            'frais_scolaire[updatedAt]' => 'Testing',
            'frais_scolaire[niveau]' => 'Testing',
            'frais_scolaire[statut]' => 'Testing',
        ]);

        self::assertResponseRedirects('/frais/scolaires/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new FraisScolaires();
        $fixture->setFraisInscription('My Title');
        $fixture->setFraisCarnet('My Title');
        $fixture->setFraisTransfert('My Title');
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
        $fixture->setAutres('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setStatut('My Title');

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
        $fixture->setFraisInscription('My Title');
        $fixture->setFraisCarnet('My Title');
        $fixture->setFraisTransfert('My Title');
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
        $fixture->setAutres('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setStatut('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'frais_scolaire[fraisInscription]' => 'Something New',
            'frais_scolaire[fraisCarnet]' => 'Something New',
            'frais_scolaire[fraisTransfert]' => 'Something New',
            'frais_scolaire[septembre]' => 'Something New',
            'frais_scolaire[octobre]' => 'Something New',
            'frais_scolaire[novembre]' => 'Something New',
            'frais_scolaire[decembre]' => 'Something New',
            'frais_scolaire[janvier]' => 'Something New',
            'frais_scolaire[fevrier]' => 'Something New',
            'frais_scolaire[mars]' => 'Something New',
            'frais_scolaire[avril]' => 'Something New',
            'frais_scolaire[mai]' => 'Something New',
            'frais_scolaire[juin]' => 'Something New',
            'frais_scolaire[autres]' => 'Something New',
            'frais_scolaire[createdAt]' => 'Something New',
            'frais_scolaire[updatedAt]' => 'Something New',
            'frais_scolaire[niveau]' => 'Something New',
            'frais_scolaire[statut]' => 'Something New',
        ]);

        self::assertResponseRedirects('/frais/scolaires/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFraisInscription());
        self::assertSame('Something New', $fixture[0]->getFraisCarnet());
        self::assertSame('Something New', $fixture[0]->getFraisTransfert());
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
        self::assertSame('Something New', $fixture[0]->getAutres());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getNiveau());
        self::assertSame('Something New', $fixture[0]->getStatut());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new FraisScolaires();
        $fixture->setFraisInscription('My Title');
        $fixture->setFraisCarnet('My Title');
        $fixture->setFraisTransfert('My Title');
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
        $fixture->setAutres('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setStatut('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/frais/scolaires/');
    }
}
