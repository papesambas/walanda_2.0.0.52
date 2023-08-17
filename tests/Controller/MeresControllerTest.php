<?php

namespace App\Test\Controller;

use App\Entity\Meres;
use App\Entity\Ninas;
use App\Entity\Noms;
use App\Entity\Prenoms;
use App\Entity\Professions;
use App\Entity\Telephones;
use App\Repository\MeresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeresControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MeresRepository $repository;
    private string $path = '/meres/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Meres::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $path = '/meres/'; // Assurez-vous que $this->path contient le bon chemin

        $crawler = $this->client->request('GET', $path);

        self::assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Meres index'); // Correction de la chaîne attendue

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
            'mere[fullname]' => 'Testing',
            'mere[createdAt]' => 'Testing',
            'mere[updatedAt]' => 'Testing',
            'mere[slug]' => 'Testing',
            'mere[nom]' => 'Testing',
            'mere[prenom]' => 'Testing',
            'mere[profession]' => 'Testing',
            'mere[telephone]' => 'Testing',
            'mere[nina]' => 'Testing',
        ]);

        self::assertResponseRedirects('/meres/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $nom = new Noms();
        $prenom = new Prenoms();
        $profession = new Professions();
        $telephone = new Telephones();
        $nina = new Ninas();
        $this->markTestIncomplete();
        $fixture = new Meres();
        $fixture->setFullname('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setNom($nom);
        $fixture->setPrenom($prenom);
        $fixture->setProfession($profession);
        $fixture->setTelephone($telephone);
        $fixture->setNina($nina);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Mere');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $nom = new Noms();
        $prenom = new Prenoms();
        $profession = new Professions();
        $telephone = new Telephones();
        $nina = new Ninas();

        $this->markTestIncomplete();
        $fixture = new Meres();
        $fixture->setFullname('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setNom($nom);
        $fixture->setPrenom($prenom);
        $fixture->setProfession($profession);
        $fixture->setTelephone($telephone);
        $fixture->setNina($nina);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'mere[fullname]' => 'Something New',
            'mere[createdAt]' => 'Something New',
            'mere[updatedAt]' => 'Something New',
            'mere[slug]' => 'Something New',
            'mere[nom]' => 'Something New',
            'mere[prenom]' => 'Something New',
            'mere[profession]' => 'Something New',
            'mere[telephone]' => 'Something New',
            'mere[nina]' => 'Something New',
        ]);

        self::assertResponseRedirects('/meres/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFullname());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getNina());
    }

    public function testRemove(): void
    {
        $nom = new Noms();
        $prenom = new Prenoms();
        $profession = new Professions();
        $telephone = new Telephones();
        $nina = new Ninas();

        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Meres();
        $fixture->setFullname('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        $fixture->setSlug('My Title');
        $fixture->setNom($nom);
        $fixture->setPrenom($prenom);
        $fixture->setProfession($profession);
        $fixture->setTelephone($telephone);
        $fixture->setNina($nina);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/meres/');
    }
}
