<?php

namespace App\Tests\Helper\Api;

use App\Helper\Api\ApiHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiHelperTest extends KernelTestCase
{
    /**
     * @param string $baseUrl
     * @param string $identifier
     * @param string $expected
     * @param bool $isInvalid
     * @return void
     * @dataProvider dataProviderForTestCreateUriFromResource
     */
    public function testCreateUriFromResource(
        string $baseUrl,
        string $identifier,
        string $expected,
        bool $isInvalid
    ): void {
        $result = ApiHelper::createUriFromResource($baseUrl, $identifier);
        if ($isInvalid === true) {
            self::assertNotSame($expected, $result);
            return;
        }
        self::assertSame($expected, $result);
    }

    /**
     * @return array
     */
    private function dataProviderForTestCreateUriFromResource(): array
    {
        return [
            'Annonce Uri Valid' => [
                "baseUrl" => "annonce",
                "identifier" => "1234-5678-91011",
                "expected" => "/annonce/1234-5678-91011",
                "isInvalid" => false
            ],
            'Annonce Uri Valid 2' => [
                "baseUrl" => "annonces-automobile",
                "identifier" => "1234-5678-91011-1234-5678",
                "expected" => "/annonces-automobile/1234-5678-91011-1234-5678",
                "isInvalid" => false
            ],
            'Annonce Uri Valid 3' => [
                "baseUrl" => "annonce",
                "identifier" => "1234-5678",
                "expected" => "/annonce/1234-5678",
                "isInvalid" => false
            ],
            'Annonce Uri Valid 4' => [
                "baseUrl" => "/annonce",
                "identifier" => "1234-5678",
                "expected" => "/annonce/1234-5678",
                "isInvalid" => false
            ],
            'Annonce Uri Valid 5' => [
                "baseUrl" => "annonce/",
                "identifier" => "1234-5678",
                "expected" => "/annonce/1234-5678",
                "isInvalid" => false
            ],
            'Annonce Uri Valid 6' => [
                "baseUrl" => "/annonce/",
                "identifier" => "1234-5678",
                "expected" => "/annonce/1234-5678",
                "isInvalid" => false
            ],
            'Annonce Uri Invalid 1' => [
                "baseUrl" => "john",
                "identifier" => "1234-5678-91011",
                "expected" => "/doe/1234-5678-91011",
                "isInvalid" => true
            ],
            'Annonce Uri Invalid 2' => [
                "baseUrl" => "john",
                "identifier" => "1234-5678-91011",
                "expected" => "/john/1234-5678",
                "isInvalid" => true
            ],
        ];
    }
}
