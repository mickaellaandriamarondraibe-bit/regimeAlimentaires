<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $allowedRoles = is_array($arguments) ? $arguments : [];
        $userRole = (string) session()->get('role');

        if ($allowedRoles !== [] && ! in_array($userRole, $allowedRoles, true)) {
            return redirect()->to('/accueil')->with('error', 'Accès refusé.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}