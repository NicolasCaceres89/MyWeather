<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Location;
use App\Models\Consult;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
    }

    /**
     * Test que se crea una ubicación correctamente con nombre de ciudad y coordenadas
     */
    public function test_location_creation_with_city_name_and_coordinates()
    {
        $locationData = [
            'cityName' => 'Madrid',
            'name' => 'Madrid City',
            'country' => 'Spain',
            'latitude' => 40.4168,
            'longitude' => -3.7038,
        ];

        $location = Location::create($locationData);

        $this->assertDatabaseHas('locations', [
            'cityName' => 'Madrid',
            'name' => 'Madrid City',
            'country' => 'Spain',
            'latitude' => 40.4168,
            'longitude' => -3.7038,
        ]);

        $this->assertNotNull($location->id);
        $this->assertEquals('Madrid', $location->cityName);
        $this->assertEquals('Madrid City', $location->name);
    }

    /**
     * Test que se crea una consulta correctamente con todos los datos
     */
    public function test_consult_creation_with_all_data()
    {
        // Crear ubicación
        $location = Location::create([
            'cityName' => 'Barcelona',
            'name' => 'Barcelona City',
            'country' => 'Spain',
            'latitude' => 41.3851,
            'longitude' => 2.1734,
        ]);

        // Crear consulta
        $consult = Consult::create([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
            'search_term' => 'Barcelona',
            'was_successful' => true,
        ]);

        $this->assertDatabaseHas('consults', [
            'user_id' => $this->user->id,
            'location_id' => $location->id,
            'search_term' => 'Barcelona',
            'was_successful' => true,
        ]);

        $this->assertNotNull($consult->id);
        $this->assertEquals($this->user->id, $consult->user_id);
        $this->assertEquals($location->id, $consult->location_id);
    }

    /**
     * Test que se crea un favorito correctamente
     */
    public function test_favorite_creation_with_location()
    {
        // Crear ubicación
        $location = Location::create([
            'cityName' => 'Valencia',
            'name' => 'Valencia City',
            'country' => 'Spain',
            'latitude' => 39.4699,
            'longitude' => -0.3763,
        ]);

        // Crear favorito
        $favorite = Favorite::create([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
        ]);

        $this->assertDatabaseHas('favorite_locations', [
            'user_id' => $this->user->id,
            'location_id' => $location->id,
        ]);

        $this->assertNotNull($favorite->id);
        $this->assertEquals($this->user->id, $favorite->user_id);
        $this->assertEquals($location->id, $favorite->location_id);
    }

    /**
     * Test que no se pueden crear favoritos duplicados
     */
    public function test_prevent_duplicate_favorites()
    {
        // Crear ubicación
        $location = Location::create([
            'cityName' => 'Sevilla',
            'name' => 'Sevilla City',
            'country' => 'Spain',
            'latitude' => 37.3891,
            'longitude' => -5.9845,
        ]);

        // Crear primer favorito
        $favorite1 = Favorite::create([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
        ]);

        // Intentar crear el mismo favorito
        $favorite2 = Favorite::firstOrCreate([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
        ]);

        // Verificar que solo hay una entrada en la BD
        $count = Favorite::where('user_id', $this->user->id)
            ->where('location_id', $location->id)
            ->count();

        $this->assertEquals(1, $count);
        $this->assertEquals($favorite1->id, $favorite2->id);
    }

    /**
     * Test que no se pueden crear ubicaciones duplicadas con las mismas coordenadas
     */
    public function test_prevent_duplicate_locations_with_same_coordinates()
    {
        // Crear primera ubicación
        $location1 = Location::create([
            'cityName' => 'Bilbao',
            'name' => 'Bilbao City',
            'country' => 'Spain',
            'latitude' => 43.2630,
            'longitude' => -2.9350,
        ]);

        // Intentar crear otra con las mismas coordenadas
        try {
            $location2 = Location::create([
                'cityName' => 'Bilbao Nueva',
                'name' => 'Bilbao New City',
                'country' => 'Spain',
                'latitude' => 43.2630,
                'longitude' => -2.9350,
            ]);
            
            // Si llegamos aquí, el test falla porque se debería haber lanzado una excepción
            $this->fail('Se debería haber lanzado una excepción por coordenadas duplicadas');
        } catch (\Exception $e) {
            // Verificar que solo hay una ubicación
            $count = Location::where('latitude', 43.2630)
                ->where('longitude', -2.9350)
                ->count();
            
            $this->assertEquals(1, $count);
        }
    }

    /**
     * Test relaciones: Una consulta debe estar relacionada con su ubicación
     */
    public function test_consult_location_relationship()
    {
        // Crear ubicación
        $location = Location::create([
            'cityName' => 'Zaragoza',
            'name' => 'Zaragoza City',
            'country' => 'Spain',
            'latitude' => 41.6488,
            'longitude' => -0.8891,
        ]);

        // Crear consulta
        $consult = Consult::create([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
            'search_term' => 'Zaragoza',
            'was_successful' => true,
        ]);

        // Verificar relación
        $this->assertNotNull($consult->location);
        $this->assertEquals($location->id, $consult->location->id);
        $this->assertEquals('Zaragoza', $consult->location->cityName);
    }

    /**
     * Test relaciones: Un favorito debe estar relacionado con su ubicación y usuario
     */
    public function test_favorite_user_location_relationships()
    {
        // Crear ubicación
        $location = Location::create([
            'cityName' => 'Murcia',
            'name' => 'Murcia City',
            'country' => 'Spain',
            'latitude' => 37.9922,
            'longitude' => -1.1307,
        ]);

        // Crear favorito
        $favorite = Favorite::create([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
        ]);

        // Verificar relaciones
        $this->assertNotNull($favorite->user);
        $this->assertNotNull($favorite->location);
        $this->assertEquals($this->user->id, $favorite->user->id);
        $this->assertEquals($location->id, $favorite->location->id);
    }

    /**
     * Test que una ubicación puede tener múltiples consultas
     */
    public function test_location_can_have_multiple_consults()
    {
        // Crear ubicación
        $location = Location::create([
            'cityName' => 'Toledo',
            'name' => 'Toledo City',
            'country' => 'Spain',
            'latitude' => 39.8628,
            'longitude' => -4.0273,
        ]);

        // Crear múltiples usuarios
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Crear consultas de diferentes usuarios para la misma ubicación
        Consult::create([
            'user_id' => $user1->id,
            'location_id' => $location->id,
            'search_term' => 'Toledo',
            'was_successful' => true,
        ]);

        Consult::create([
            'user_id' => $user2->id,
            'location_id' => $location->id,
            'search_term' => 'Toledo',
            'was_successful' => true,
        ]);

        // Verificar que la ubicación tiene dos consultas
        $this->assertEquals(2, $location->consults()->count());
    }

    /**
     * Test integración completa: Crear ubicación, consulta y favorito
     */
    public function test_complete_integration_location_consult_favorite()
    {
        // Crear ubicación con todos los datos
        $location = Location::create([
            'cityName' => 'Málaga',
            'name' => 'Málaga City',
            'country' => 'Spain',
            'latitude' => 36.7213,
            'longitude' => -4.4213,
        ]);

        // Crear consulta
        $consult = Consult::create([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
            'search_term' => 'Málaga',
            'was_successful' => true,
        ]);

        // Crear favorito
        $favorite = Favorite::create([
            'user_id' => $this->user->id,
            'location_id' => $location->id,
        ]);

        // Verificar que todos los datos estén guardados correctamente
        $this->assertDatabaseCount('locations', 1);
        $this->assertDatabaseCount('consults', 1);
        $this->assertDatabaseCount('favorite_locations', 1);

        // Verificar integridad de datos
        $retrievedLocation = Location::find($location->id);
        $this->assertEquals('Málaga', $retrievedLocation->cityName);
        $this->assertEquals(36.7213, $retrievedLocation->latitude);
        $this->assertEquals(-4.4213, $retrievedLocation->longitude);

        $retrievedConsult = Consult::find($consult->id);
        $this->assertEquals($this->user->id, $retrievedConsult->user_id);
        $this->assertTrue($retrievedConsult->was_successful);

        $retrievedFavorite = Favorite::find($favorite->id);
        $this->assertEquals($this->user->id, $retrievedFavorite->user_id);
        $this->assertEquals($location->id, $retrievedFavorite->location_id);
    }
}
