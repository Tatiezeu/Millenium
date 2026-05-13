<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() { return view('dashboard.index'); }
    public function reservations() { return view('dashboard.reservations'); }
    public function tables() { return view('dashboard.tables'); }
    public function services() { return view('dashboard.services'); }
    public function events() { return view('dashboard.events'); }
    public function gallery() { return view('dashboard.gallery'); }
    public function orders() { return view('dashboard.orders'); }
    public function myOrders() { return view('dashboard.my-orders'); }
    public function cashier() { return view('dashboard.cashier'); }
    public function staffAccounts() { return view('dashboard.staff-accounts'); }
    public function notifications() { return view('dashboard.notifications'); }
    public function reports() { return view('dashboard.reports'); }
    public function profile() { return view('dashboard.profile'); }
    public function settings() { return view('dashboard.settings'); }
}
