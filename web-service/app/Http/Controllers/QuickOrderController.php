<?php

namespace App\Http\Controllers;

/**
 * Class QuickOrderController
 *
 * @package App\Http\Controllers
 */
class QuickOrderController extends Controller
{
    /**
     * Entry point for Quick Order Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function client()
    {
        return view('client');
    }
    public function admin()
    {
        return view('admin');
    }
}
