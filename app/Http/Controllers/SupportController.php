<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function show()
    {
        return view('support.form');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Formato de email inválido.',
            'message.required' => 'A mensagem é obrigatória.',
        ]);

        $nome = $validated['name'];
        $email = $validated['email'];
        $mensagem = $validated['message'];

        $corpo = "Nome: $nome\nEmail: $email\nMensagem:\n$mensagem";

        Mail::raw($corpo, function ($msg) use ($nome, $email) {
            $msg->to('suportetec200y@gmail.com')
                ->subject('Formulário de Suporte - ' . $nome)
                ->replyTo($email);
        });

        return redirect()->route('support.form')
            ->with('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
    }
}
