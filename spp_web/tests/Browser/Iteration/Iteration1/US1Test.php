<?php

namespace Tests\Browser\Iteration\Iteration1;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class US1Test extends DuskTestCase
{
    public function attemptLogin($credentials, $configs)
    {
        $this->browse(function (Browser $browser) use ($credentials, $configs) {
            $browser->visit('/login')
                ->type('email', $credentials['email'])
                ->type('password', $credentials['password'])
                ->press('Sign In');
            if ($configs['assertSee']) {
                foreach ($configs['assertSee'] as $text) {
                    $browser->assertSee($text);
                }
            }
            if ($configs['assertPath']) {
                foreach ($configs['asserPath'] as $path) {
                    $browser->assertPathIs($path);
                }
            }
        });
    }

    public function addUser($credentials, $configs)
    {
        $this->browse(function (Browser $browser) use ($credentials, $configs) {
            $user = User::find(1);
            $browser->loginAs($user)->visit('/dashboard/settings/users/create')
                ->type('name', $credentials['name'])
                ->type('email', $credentials['email'])
                ->type('password', $credentials['password'])
                ->radio('roles', $credentials['roles']);
            if ($credentials['roles'] == 2) {
                $browser->check($credentials['responsibility']);
            }
            if ($credentials['roles'] == 3) {
                $browser->check($credentials['responsibility']);
            }
            $browser->press('Simpan');
            if ($configs['assertSee']) {
                foreach ($configs['assertSee'] as $text) {
                    $browser->assertSee($text);
                }
            }
            if ($configs['shouldLogout']) {
                $browser
                    ->logout();
            }
        });
    }

    public function test_us_01_ts_01(): void
    {
        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra@gmail.com',
            'password'  =>  'password',
            'roles' =>  1
        ];
        $addUserConfigs = [
            'assertSee' =>  [
                __('message.user.created')
            ],
            'shouldLogout'  =>  true
        ];
        $loginConfigs = [
            'assertSee' =>  [
                $credentials['name']
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);
    }

    public function test_us_01_ts_02(): void
    {
        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra',
            'password'  =>  'password',
            'roles' =>  1
        ];
        $addUserConfigs = [
            'assertSee' =>  [
                __('message.validation.error')
            ],
            'shouldLogout'  =>  true
        ];

        $loginConfigs = [
            'assertPath' =>  [
                'login'
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);

        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra',
            'password'  =>  'passwordpassword',
            'roles' =>  1
        ];

        $loginConfigs = [
            'assertSee' =>  [
                'These credentials do not match our records.'
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);
    }

    public function test_us_01_ts_03()
    {
        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra@gmail.com',
            'password'  =>  'password',
            'roles' =>  2,
            'responsibility'    =>  '#divisions_1',
        ];
        $addUserConfigs = [
            'assertSee' =>  [
                __('message.user.created')
            ],
            'shouldLogout'  =>  true
        ];
        $loginConfigs = [
            'assertSee' =>  [
                $credentials['name']
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);
    }

    public function test_us_01_ts_04(): void
    {
        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra',
            'password'  =>  'password',
            'roles' =>  2,
            'responsibility'    =>  '#divisions_1',
        ];
        $addUserConfigs = [
            'assertSee' =>  [
                __('message.validation.error')
            ],
            'shouldLogout'  =>  true
        ];

        $loginConfigs = [
            'assertSee' =>  [
                'Please include an \'@\' in the email address.'
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);

        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra',
            'password'  =>  'passwordpassword',
            'roles' =>  1,
            'responsibility'    =>  '#divisions_1',
        ];

        $loginConfigs = [
            'assertSee' =>  [
                'These credentials do not match our records.'
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);
    }

    public function test_us_01_ts_05()
    {
        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra@gmail.com',
            'password'  =>  'password',
            'roles' =>  2,
            'responsibility'    =>  '#villages_1',
        ];
        $addUserConfigs = [
            'assertSee' =>  [
                __('message.user.created')
            ],
            'shouldLogout'  =>  true
        ];
        $loginConfigs = [
            'assertSee' =>  [
                $credentials['name']
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);
    }

    public function test_us_01_ts_06(): void
    {
        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra',
            'password'  =>  'password',
            'roles' =>  2,
            'responsibility'    =>  '#villages_1',
        ];
        $addUserConfigs = [
            'assertSee' =>  [
                __('message.validation.error')
            ],
            'shouldLogout'  =>  true
        ];

        $loginConfigs = [
            'assertPath' =>  [
                'login'
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);

        $credentials = [
            'name'  =>  'ackyra',
            'email' =>  'ackyra',
            'password'  =>  'passwordpassword',
            'roles' =>  1,
            'responsibility'    =>  '#villages_1',
        ];

        $loginConfigs = [
            'assertSee' =>  [
                'These credentials do not match our records.'
            ]
        ];

        $this->addUser($credentials, $addUserConfigs);

        $this->attemptLogin($credentials, $loginConfigs);
    }

    public function test_us_01_ts_07(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)->visit('/dashboard/settings/users')
                ->press('Lihat');
            $targetUser = User::where('name', $browser->inputValue('name'))
                ->where('email', $browser->inputValue('email'))
                ->first();
        });
    }
}
