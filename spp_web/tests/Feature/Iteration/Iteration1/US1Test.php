<?php

namespace Tests\Feature\Iteration\Iteration1;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\District;
use App\Models\Division;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::find(1));
    }

    /**
     * @dataProvider userDataProvider
     */
    public function test_kepala_dinas_can_add_user_with_valid_credentials($userData)
    {
        $response = $this->post('/dashboard/settings/users/', $userData);

        $this->assertDatabaseHas('users', ['email' => $userData['email']]);

        $newUser = User::where('email', $userData['email'])->first();

        $authResponse = $this->actingAs($newUser);

        $authResponse->assertAuthenticated();
        return $newUser;
    }

    /**
     * @dataProvider invalidUserDataProvider
     */
    public function test_kepala_dinas_cannot_add_user_with_invalid_credentials($userData)
    {
        $response = $this->post('/dashboard/settings/users', $userData);

        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('users', ['email' => $userData['email']]);
    }

    public function userDataProvider()
    {
        return [
            'valid_user_role_1' => [
                [
                    'name' => 'New User Role 1',
                    'email' => 'newKadis@valid.com',
                    'password' => 'password',
                    'roles' => 1,
                ],
            ],
            'valid_user_role_2' => [
                [
                    'name' => 'New User Role 2',
                    'email' => 'newKabid@valid.com',
                    'password' => 'password',
                    'roles' => 2,
                    'divisions' =>  1
                ],
            ],
            'valid_user_role_3' => [
                [
                    'name' => 'New User Role 3',
                    'email' => 'newKoor@valid.com',
                    'password' => 'password',
                    'roles' => 3,
                    'villages'  =>  1
                ],
            ],
        ];
    }

    public function invalidUserDataProvider()
    {
        return [
            'invalid_user_role_1' => [
                [
                    'name' => 'New User Role 1',
                    'email' => 'newuserrole1@invalid',
                    'password' => 'short',
                    'roles' => 1,
                ],
            ],
            'invalid_user_role_2' => [
                [
                    'name' => 'New User Role 2',
                    'email' => 'newuserrole2@invalid',
                    'password' => 'short',
                    'roles' => 2,
                ],
            ],
            'invalid_user_role_3' => [
                [
                    'name' => 'New User Role 3',
                    'email' => 'newuserrole3@invalid',
                    'password' => 'short',
                    'roles' => 3,
                ],
            ],
        ];
    }

    public function test_kepala_dinas_can_update_user_role()
    {
        // Get a random user to update
        $userToUpdate = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'kadis');
        })->inRandomOrder()->first();

        // Get the initial role of the user
        $initialRole = $userToUpdate->roles->pluck('id')->first();

        // Get all roles except the initial one
        $targetRoles = Role::where('id', '<>', $initialRole)->pluck('id');

        foreach ($targetRoles as $targetRole) {
            // Prepare updated user data
            $updatedUserData = [
                'name' => 'Updated User',
                'email' => 'updateduser@valid.com',
                'password' => 'newpassword',
                'roles' => $targetRole,
            ];

            // Perform the update
            $response = $this->put("/dashboard/settings/users/{$userToUpdate->id}", $updatedUserData);

            // Assert the response status
            $response->assertStatus(302);

            // Fetch the user again from the database after the update
            $updatedUser = User::find($userToUpdate->id);

            // Assert that the user in the database is updated with the new role
            $this->assertDatabaseHas('users', [
                'id' => $updatedUser->id,
                'name' => $updatedUserData['name'],
                'email' => $updatedUserData['email'],
            ]);

            // Assert that the user's role is updated
            $this->assertTrue($updatedUser->roles->pluck('id')->contains($targetRole));
        }
    }

    public function test_kepala_dinas_can_update_user_role_and_scope_for_kabid()
    {
        // Get a user with the role to update
        $userToUpdate = User::whereHas('roles', function ($query) {
            $query->where('id', '2'); // Change this to the role you want to update
        })->whereHas('divisions')->inRandomOrder()->first();

        // Check if a user with the specified role and divisions is found
        if ($userToUpdate) {
            // Choose a different role to update
            $newRole = Role::where('id', '<>', $userToUpdate->roles->pluck('id')->first())->inRandomOrder()->first();

            // Choose a different division to update
            $newDivision = Division::whereNotIn('id', $userToUpdate->divisions->pluck('id'))->inRandomOrder()->first();

            // Prepare the updated user data
            $updatedUserData = [
                'name' => 'Updated User',
                'email' =>  $userToUpdate->email,
                'roles' => $newRole->id,
                'divisions' => $newDivision->id,
            ];

            // Perform the update
            $response = $this->put("/dashboard/settings/users/{$userToUpdate->id}", $updatedUserData);

            // Assert the response status
            $response->assertStatus(302); // Adjust as needed

            // Refresh the user instance from the database
            $userToUpdate->refresh();

            // Assert the user's role is updated
            $this->assertEquals($newRole->id, $userToUpdate->roles->pluck('id')->first());

            // Assert the user's division is updated
            $this->assertEquals($newDivision->id, $userToUpdate->divisions->pluck('id')->first());
        } else {
            $this->markTestSkipped('No user with the specified role and divisions found for update test.');
        }
    }
    public function test_kepala_dinas_can_update_user_role_and_scope_for_koor()
    {
        // Get a user with the role to update
        $userToUpdate = User::whereHas('roles', function ($query) {
            $query->where('id', '3');
        })->whereHas('districts')->inRandomOrder()->first();
        if ($userToUpdate) {
            // Choose a different role to update
            $newRole = Role::where('id', '<>', $userToUpdate->roles->pluck('id')->first())->inRandomOrder()->first();

            // Choose a different division to update
            $newDistrict = District::whereNotIn('id', $userToUpdate->districts->pluck('id'))->inRandomOrder()->first();

            $updatedUserData = [
                'name' => 'Updated User',
                'email' =>  $userToUpdate->email,
                'roles' => $newRole->id,
                'villages' => $newDistrict->id,
            ];

            // Perform the update
            $response = $this->put("/dashboard/settings/users/{$userToUpdate->id}", $updatedUserData);

            // Assert the response status
            $response->assertStatus(302); // Adjust as needed

            // Refresh the user instance from the database
            $userToUpdate->refresh();

            // Assert the user's role is updated
            $this->assertEquals($newRole->id, $userToUpdate->roles->pluck('id')->first());

            // Assert the user's division is updated
            $this->assertEquals($newDistrict->id, $userToUpdate->districts->pluck('id')->first());
        } else {
            $this->markTestSkipped('No user with the specified role and divisions found for update test.');
        }
    }

    public function test_kepala_dinas_can_update_user_credentials()
    {
        // Get a user to update (excluding the role "Kadis")
        $userToUpdate = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Kadis');
        })->inRandomOrder()->first();

        // Check if there's a user to update, otherwise skip the test
        if (!$userToUpdate) {
            $this->markTestSkipped('No user found for the update test.');
        }

        // Prepare the updated user data
        $updatedUserData = [
            'name' => 'Updated User',
            'email' => 'updateduser@example.com',
            'roles' =>  $userToUpdate->roles,
        ];

        // Check the user's role and add additional data if it's role 2 or 3
        if (($userToUpdate->hasRole('kabid'))) {
            $updatedUserData['divisions'] = Division::whereNotIn('id', $userToUpdate->divisions->pluck('id'))->inRandomOrder()->first();
        }
        if (($userToUpdate->hasRole('koor'))) {
            $updatedUserData['villages'] = District::whereNotIn('id', $userToUpdate->districts->pluck('id'))->inRandomOrder()->first();
        }

        // Perform the update
        $response = $this->put("/dashboard/settings/users/{$userToUpdate->id}", $updatedUserData);

        // Assert the response status
        $response->assertStatus(302); // Adjust as needed

        // Refresh the user instance from the database
        $userToUpdate->refresh();

        // Assert the user's name is updated
        $this->assertEquals($updatedUserData['name'], $userToUpdate->name);

        // Assert the user's email is updated
        $this->assertEquals($updatedUserData['email'], $userToUpdate->email);

        // Assert the additional data (divisions or villages) is updated
        if (isset($updatedUserData['divisions'])) {
            $this->assertTrue($userToUpdate->divisions->contains($updatedUserData['divisions']));
        }
        if (isset($updatedUserData['villages'])) {
            $this->assertTrue($userToUpdate->districts->contains($updatedUserData['villages']));
        }

        $authResponse = $this->actingAs($userToUpdate);

        $authResponse->assertAuthenticated();
    }
}
