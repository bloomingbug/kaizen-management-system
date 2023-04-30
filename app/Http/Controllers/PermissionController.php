<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'permission:permission.index'
        ]);
    }

    public function __invoke(Request $request)
    {
        $permissions = Permission::when(request()->q, function ($permissions) {
            $permissions = $permissions->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        return Inertia::render('Permission/Index', [
            'permissions' => $permissions,
        ]);
    }
}
