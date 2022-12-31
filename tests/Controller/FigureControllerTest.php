<?php

namespace App\Test\Controller;

use App\Entity\Figure;
use App\Repository\FigureRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FigureControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FigureRepository $repository;
    private string $path = '/figure/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Figure::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Figure index');

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
            'figure[name]' => 'Testing',
            'figure[description]' => 'Testing',
            'figure[CreatedAt]' => 'Testing',
            'figure[modifiedAt]' => 'Testing',
            'figure[imgfilename]' => 'Testing',
            'figure[groupe]' => 'Testing',
            'figure[author]' => 'Testing',
        ]);

        self::assertResponseRedirects('/figure/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Figure();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setModifiedAt('My Title');
        $fixture->setImgfilename('My Title');
        $fixture->setGroupe('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Figure');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Figure();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setModifiedAt('My Title');
        $fixture->setImgfilename('My Title');
        $fixture->setGroupe('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'figure[name]' => 'Something New',
            'figure[description]' => 'Something New',
            'figure[CreatedAt]' => 'Something New',
            'figure[modifiedAt]' => 'Something New',
            'figure[imgfilename]' => 'Something New',
            'figure[groupe]' => 'Something New',
            'figure[author]' => 'Something New',
        ]);

        self::assertResponseRedirects('/figure/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getModifiedAt());
        self::assertSame('Something New', $fixture[0]->getImgfilename());
        self::assertSame('Something New', $fixture[0]->getGroupe());
        self::assertSame('Something New', $fixture[0]->getAuthor());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Figure();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setModifiedAt('My Title');
        $fixture->setImgfilename('My Title');
        $fixture->setGroupe('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/figure/');
    }
}
