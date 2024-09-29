<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ManagementService;

class ManagementController extends Controller
{
    protected $managementService;

    public function __construct(ManagementService $managementService)
    {
        $this->managementService = $managementService;
    }

    public function index()
    {
        $data = $this->managementService->index();
        return view('Shop.management.index', $data);
    }

    public function users()
    {
        $data = $this->managementService->index();
        return view('Shop.management.users', $data);
    }

    public function products()
    {
        $data = $this->managementService->index();
        return view('Shop.management.products', $data);
    }

    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $this->managementService->update($request, $user);
    }

}
