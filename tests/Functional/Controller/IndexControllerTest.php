<?php

namespace App\Tests\Functional\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    const TEST_MAIL = 'comunity@phpmx.mx';

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
        $client = self::createClient();
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
        $client = self::createClient();
        $entityManager = $client->getContainer()
            ->get('doctrine')
            ->getManager();

        $client->request('GET', '/');

        $client->submitForm('Join', [
            'sign_up' => [
                'username' => 'phpmx',
                'email' => self::TEST_MAIL,
            ],
        ]);

        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'email' => self::TEST_MAIL,
            ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertStringContainsString('Enviamos un enlace a tu email para verificar tu cuenta y completar tu perfil.', $client->getResponse()->getContent());

        $entityManager->remove($user);
        $entityManager->flush();
    }

    public function provideWrongEmail(): array
    {
        return [
            [
                'bad mail_bad format.com',
                'El valor introducido parece no ser un email válido',
            ],
            [
                '0815.su', //not throwable email vendor/email-checker/res/throwaway_domains.txt
                'Correo Invalido',
            ],
        ];
    }
}
