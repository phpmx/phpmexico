<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    /** @test */
    public function showIndexPage()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1.white-text', 'La comunidad de PHP en México');
        $this->assertSelectorTextContains('#join', 'Únete a PHP Mx');
    }

    /**
     * @dataProvider provideWrongEmail
     *
     * @test
     */
    public function invalidEmail(string $wrongMail, string $expectedMessage)
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $client->submitForm('Join', [
            'sign_up' => [
                'email' => $wrongMail,
            ],
        ]);

        $this->assertStringContainsString($expectedMessage, $client->getResponse()->getContent());
    }

    /** @test */
    public function registerNewUser()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $client->submitForm('Join', [
            'sign_up' => [
                'username' => 'phpmx',
                'email' => 'comunity@phpmx.mx',
            ],
        ]);

        $this->assertStringContainsString('Hemos enviado correos a tu email', $client->getResponse()->getContent());
    }

    public function provideWrongEmail(): array
    {
        return [
            [
                'bad mail_bad format.com',
                'el valor introducido parece no ser un email',
            ],
            [
                'comunidad@phpmexico.mx',
                'Correo Invalido',
            ],
        ];
    }
}
