<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display the login form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function show()
    {
        return view('login');
    }

    /**
     * Check if the login credentials are correct
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        if ($request->get('email') === 'admin' && $request->get('password') === 'admin') {
            session()->push('admin', true);

            return redirect()->route('admin.products.index');
        }

        return back()
            ->withInput($request->all())
            ->withErrors([
                'email' => [
                    __('Email of password are incorrect!')
                ]
            ]);
    }

    /**
     * Log out the user
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        session()->forget('admin');

        return redirect()->route('show.login');
    }
}
