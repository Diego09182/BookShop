<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return $this->profileService->index();
    }

    public function update(Request $request)
    {
        return $this->profileService->update($request);
    }
    
}