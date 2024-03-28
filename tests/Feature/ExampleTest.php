<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase; 
    /**
     * Test get all users
     */
    public function test_api_get_users_response(): void
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }

    /**
     * Test get user token
     */
    public function test_api_get_user_token(): void 
    {
        // Créer un utilisateur pour le test
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => \bcrypt('1234'),
        ]);

        $data = [
            'email'=> 'john@example.com',
            'password' => '1234',
        ];

        // Utilisation de la méthode post() pour envoyer des données POST à l'URL spécifiée
        $response = $this->post('/api/tokens/create', $data);

        // Vérifiez que la réponse HTTP est 200 (OK) ou autre statut attendu
        $response->assertStatus(200);

        // Vous pouvez également vérifier le contenu de la réponse si nécessaire
        $response->assertJson([
            'success' => true,
        ]); // Suppose que votre contrôleur renvoie 'Success' si tout va bien
    }
}
