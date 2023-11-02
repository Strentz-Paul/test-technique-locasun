<?php

namespace App\Tests\Helper\Vehicule;

use App\Enum\MarqueVehiculeEnum;
use App\Helper\Vehicule\MarqueHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MarqueHelperTest extends KernelTestCase
{
    /**
     * @param string $input
     * @param MarqueVehiculeEnum|null $expected
     * @return void
     * @dataProvider dataProviderForTestsDefineMarqueByModele
     */
    public function testDefineMarqueByModele(
        string $input,
        ?MarqueVehiculeEnum $expected
    ): void {
        if ($expected === null) {
            self::expectException(Exception::class);
        }
        $result = MarqueHelper::defineMarqueByModele($input);
        self::assertSame($expected, $result);
    }

    /**
     * @return array<array>
     */
    private function dataProviderForTestsDefineMarqueByModele(): array
    {
        return [
            'Test Audi 1' => [
                'input' => 'Rs3',
                'expected' => MarqueVehiculeEnum::AUDI
            ],
            'Test Audi 2' => [
                'input' => 'Rs3',
                'expected' => MarqueVehiculeEnum::AUDI
            ],
            'Test Audi 3' => [
                'input' => 'Rs3',
                'expected' => MarqueVehiculeEnum::AUDI
            ],
            'Test Audi 4' => [
                'input' => 'Rs3',
                'expected' => MarqueVehiculeEnum::AUDI
            ],
            'Test Audi 5' => [
                'input' => 'Rs3',
                'expected' => MarqueVehiculeEnum::AUDI
            ],
            'Test BMW 1' => [
                'input' => 'M3',
                'expected' => MarqueVehiculeEnum::BMW
            ],
            'Test BMW 2' => [
                'input' => 'M3',
                'expected' => MarqueVehiculeEnum::BMW
            ],
            'Test BMW 3' => [
                'input' => 'M3',
                'expected' => MarqueVehiculeEnum::BMW
            ],
            'Test BMW 4' => [
                'input' => 'M3',
                'expected' => MarqueVehiculeEnum::BMW
            ],
            'Test BMW 5' => [
                'input' => 'M3',
                'expected' => MarqueVehiculeEnum::BMW
            ],
            'Test Citroen 1' => [
                'input' => 'C1',
                'expected' => MarqueVehiculeEnum::CITROEN
            ],
            'Test Citroen 2' => [
                'input' => 'C1',
                'expected' => MarqueVehiculeEnum::CITROEN
            ],
            'Test Citroen 3' => [
                'input' => 'C1',
                'expected' => MarqueVehiculeEnum::CITROEN
            ],
            'Test Citroen 4' => [
                'input' => 'C1',
                'expected' => MarqueVehiculeEnum::CITROEN
            ],
            'Test Citroen 5' => [
                'input' => 'C1',
                'expected' => MarqueVehiculeEnum::CITROEN
            ],
            'Test Fail 1' => [
                'input' => 'Twingo',
                'expected' => null
            ],
            'Test Fail 2' => [
                'input' => '3',
                'expected' => null
            ],
            'Test Fail 3' => [
                'input' => 'Ariane',
                'expected' => null
            ]
        ];
    }
}
