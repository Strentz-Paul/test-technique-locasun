<?php

namespace App\Tests\Manager;

use App\Contracts\Manager\VehiculeManagerInterface;
use App\Enum\MarqueVehiculeEnum;
use App\Manager\VehiculeManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VehiculeManagerTest extends KernelTestCase
{
    private VehiculeManager $service;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        /** @var VehiculeManagerInterface $service */
        $service = $kernel->getContainer()->get(VehiculeManagerInterface::class);
        $this->service = $service;
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @param string $input
     * @param string $expectedModele
     * @param string $expectedMarque
     * @param bool $isMissing
     * @return void
     * @throws Exception
     * @dataProvider dataProviderForTestFindVehiculeMatch
     */
    public function testFindVehiculeMatch(
        string $input,
        string $expectedModele,
        string $expectedMarque,
        bool $isMissing = false
    ): void {
        if ($isMissing === true) {
            self::expectException(Exception::class);
            var_dump($this->service->findVehiculeMatch($input)->getIntitule());
            return;
        }
        $result = $this->service->findVehiculeMatch($input);
        self::assertSame($expectedModele, $result->getIntitule());
        self::assertSame(MarqueVehiculeEnum::from($expectedMarque), $result->getMarque());
    }

    /**
     * @return array
     */
    private function dataProviderForTestFindVehiculeMatch(): array
    {
        return [
            'Simple match' => [
                'input' => 'RS4',
                'expectedModele' => 'Rs4',
                'expectedMarque' => 'Audi'
            ],
            'Simple match 2' => [
                'input' => 'Série 7',
                'expectedModele' => 'Serie 7',
                'expectedMarque' => 'BMW'
            ],
            'Simple match 3' => [
                'input' => 'C25TD',
                'expectedModele' => 'C25TD',
                'expectedMarque' => 'Citroen'
            ],
            'Complexe match' => [
                'input' => 'Gran Turismo Série5',
                'expectedModele' => 'Serie 5',
                'expectedMarque' => 'BMW'
            ],
            'Complexe match 2' => [
                'input' => 'rs4 avant',
                'expectedModele' => 'Rs4',
                'expectedMarque' => 'Audi'
            ],
            'Complexe match 3' => [
                'input' => 'ds 3 crossback',
                'expectedModele' => 'Ds3',
                'expectedMarque' => 'Citroen'
            ],
            'Complexe match 4' => [
                'input' => 'CrossBack ds 3',
                'expectedModele' => 'Ds3',
                'expectedMarque' => 'Citroen'
            ],
            'Match fail' => [
                'input' => 'Twingo',
                'expectedModele' => '',
                'expectedMarque' => '',
                'isMissing' => true
            ],
        ];
    }
}
