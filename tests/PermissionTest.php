<?php

namespace TCG\Voyager\Tests;

use TCG\Voyager\Models\Role;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->install();

        Auth::loginUsingId(1);
    }

    public function testPermissionNotExisting()
    {
        // This behavior should maybe be changed in v1.0 to throw a exception

        $this->assertTrue(Voyager::can('test'));
    }

    public function testNotHavingPermission()
    {
        Permission::create(['key' => 'test']);

        $this->assertFalse(Voyager::can('test'));
    }

    public function testHavingPermission()
    {
        $role = Role::find(1)
            ->permissions()
            ->create(['key' => 'test']);

        $this->assertTrue(Voyager::can('test'));
    }
}
