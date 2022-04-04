<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\AuthModel;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('home');
    }

    public function index()
    {
        return view('home');
    }

    public function mail()
    {
        return new PasswordResetMail(AuthModel::first(), '123');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function dataDeletion()
    {
        return view('data-deletion');
    }
}
