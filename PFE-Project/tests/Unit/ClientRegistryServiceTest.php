<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use App\Models\User;
use App\Models\Evolution;
use App\Services\ClientRegistryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\UserSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\EvolutionSeeder;

class ClientRegistryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ClientRegistryService();
        
        $this->seed(UserSeeder::class);
        $this->seed(ClientSeeder::class);
        $this->seed(EvolutionSeeder::class);
    }

    public function test_it_can_get_detailed_registry_without_search()
    {
        $registry = $this->service->getDetailedRegistry();
        $this->assertNotEmpty($registry);
        $this->assertInstanceOf(Client::class, $registry->first());
        $this->assertNotNull($registry->first()->user);
    }

    public function test_it_can_get_detailed_registry_with_search()
    {
        $client = Client::with('user')->first();
        $searchName = substr($client->user->name, 0, 3);

        $registry = $this->service->getDetailedRegistry($searchName);
        
        $this->assertNotEmpty($registry);
        foreach ($registry as $item) {
            $this->assertStringContainsStringIgnoringCase($searchName, $item->user->name);
        }
    }

    public function test_it_can_calculate_biometrics()
    {
        $client = Client::first();
        $client->evolutions()->delete();
        $client->update(['height' => 1.75]);
        
        Evolution::create([
            'client_id' => $client->id,
            'weight' => 70,
            'recorded_at' => now()->toDateString()
        ]);

        $biometrics = $this->service->calculateBioMetrics($client->fresh(['evolutions']));

        $this->assertNotNull($biometrics);
        $this->assertArrayHasKey('bmi', $biometrics);
        $this->assertEquals(22.9, $biometrics['bmi']);
    }

    public function test_it_calculates_weight_trend()
    {
        $client = Client::first();
        $client->evolutions()->delete();
        
        Evolution::create([
            'client_id' => $client->id,
            'weight' => 75,
            'recorded_at' => now()->subDays(7)->toDateString()
        ]);
        Evolution::create([
            'client_id' => $client->id,
            'weight' => 72,
            'recorded_at' => now()->toDateString()
        ]);

        $biometrics = $this->service->calculateBioMetrics($client->fresh(['evolutions']));
        $this->assertEquals(-3, $biometrics['trend']);
    }

    public function test_it_can_add_a_client()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'phone_number' => '123456789',
            'status' => 'active',
            'target_goal' => 75.0,
            'current_weight' => 85.0,
            'height' => 1.80
        ];

        $client = $this->service->addClient($data);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertDatabaseHas('clients', ['phone_number' => '123456789', 'target_goal' => 75.0]);
    }

    public function test_it_can_update_a_client()
    {
        $client = Client::first();
        $data = [
            'name' => 'Updated Name',
            'phone_number' => '999999999'
        ];

        $updatedClient = $this->service->updateClient($client->id, $data);

        $this->assertEquals('Updated Name', $updatedClient->user->name);
        $this->assertEquals('999999999', $updatedClient->phone_number);
    }

    public function test_it_can_delete_a_client()
    {
        $client = Client::first();
        $userId = $client->user_id;

        $this->service->deleteClient($client->id);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }
}
