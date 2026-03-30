<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Muestra la vista del formulario de inicio de sesión
    public function login()
    {
        return view('auth.login'); // la vista de login
    }

    // Redirección después del login según el rol del usuario
    protected function redirectPath()
    {
        $user = Auth::user(); // Toma el usuario que acabe de entrar

        switch ($user->idrol) { // Revisa su idrol
            case 2:
                //return 'home/jugador';
                //return 'jugador/profile';
                return '/';
                // Si es diferente a 2 lo manda en 'home/administrador'
            default: 
                return '/jugador';
        }
    }

    // Método personalizado para iniciar sesión
    public function iniciar_sesion(Request $request) //Muestra el formulario para entrar
    {   
        //Aquí el sistema recibe los datos del formulario (correo y contraseña)
        $credentials = $request->only('email', 'password'); // Guarda esos datos 

        // intenta iniciar sesión con esas credenciales que es el email y password
        if (Auth::attempt($credentials)) {
            
            //Crea un nuevo ID de sesión.
            //Asocia todos los datos actuales de la sesión a ese nuevo ID.
            //Invalida el ID anterior, eliminando la posibilidad de reutilizarlo.
            $request->session()->regenerate(); // Evita fijación de sesión

            // Redirige según el rol
            return redirect()->intended($this->redirectPath());
        }

        // Si la contraseña o el correo están mal, vuelve al formulario y muestra un mensaje de error
        return back()->withErrors([ //Envía un mensaje de error a esa vista.
            'email' => 'Credenciales incorrectas', 
        ])->onlyInput('email'); //Guarda temporalmente el valor del campo “email” que el usuario escribió.
    }

    // Cierra la sesión 
    public function logout()
    {
        Session::flush(); //Borra todos los datos de sesion
        Auth::logout(); // cierra la sesion del usuario
        return redirect()->route('login'); // Me regresa a la vista de login
    }
}
