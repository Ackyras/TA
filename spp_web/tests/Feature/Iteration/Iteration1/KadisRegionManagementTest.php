<?php

namespace Tests\Feature\Iteration\Iteration1;

use App\Models\District;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KadisRegionManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::find(1));
    }

    public function test_kepala_dinas_can_add_district()
    {
        $districtData = [
            'name' => 'New District',
        ];

        $response = $this->post(route('dashboard.district.store'), $districtData);

        $response->assertSessionHas('created', __('message.district.created')); // Check if success message is in session

        $this->assertDatabaseHas('districts', $districtData); // Check if district is in the database

        $response = $this->get(route('dashboard.district.index'));
        $response->assertSee($districtData['name']); // Check if district name is in the response

        // Log response content
        dump($response->getContent());
    }

    public function test_kepala_dinas_can_add_village()
    {
        $villageData = [
            'name' => 'New Village',
            'district_id' => District::inRandomOrder()->first()->id, // Assuming at least one district exists
        ];

        $response = $this->post(route('dashboard.village.store'), $villageData);

        $newVillage = Village::where('name', $villageData)->first();
        $response->assertSee($newVillage->name);

        $this->assertDatabaseHas('villages', $villageData);
    }

    public function test_kepala_dinas_can_update_district()
    {
        $districtToUpdate = District::first();

        $updatedDistrictData = [
            'name' => 'Updated District',
        ];

        $response = $this->put(route('dashboard.district.update', $districtToUpdate->id), $updatedDistrictData);

        $this->assertDatabaseHas('districts', $updatedDistrictData);
    }

    public function test_kepala_dinas_can_update_village()
    {
        $villageToUpdate = Village::first();

        $updatedVillageData = [
            'name' => 'Updated Village',
        ];

        $response = $this->put(route('dashboard.village.update', $villageToUpdate->id), $updatedVillageData);

        $this->assertDatabaseHas('villages', $updatedVillageData);
    }

    public function test_kepala_dinas_can_delete_district()
    {
        $districtToDelete = District::first();

        $response = $this->delete(route('dashboard.district.destroy', $districtToDelete->id));

        $this->assertNull(
            District::find($districtToDelete->id)
                ->first()
        );
    }

    public function test_kepala_dinas_can_delete_village()
    {
        $villageToDelete = Village::first();

        $response = $this->delete(route('dashboard.village.destroy', $villageToDelete->id));

        $this->assertNull(
            Village::find($villageToDelete->id)
                ->first()
        );
    }
}
