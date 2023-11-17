<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\admin\AdminService;

class AdminController extends Controller
{
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $halls = $this->adminService->getAdminPanel();

        return view('admin.index', $halls);
    }

    public function openSells()
    {
        $this->adminService->openSells();

        return redirect()->back()->with('is_opened_sells', true);
    }
}
