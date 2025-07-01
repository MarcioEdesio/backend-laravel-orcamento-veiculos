<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrcamentoController extends Controller
{
    public function enviar(Request $request)
    {
        // Validação dos campos
        $this->validate($request, [
            'nome' => 'required|string',
            'whatsapp' => 'required|string',
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'ano' => 'required|integer',
            // 'fotos' => 'array', // se quiser validar fotos como array
            // 'fotos.*' => 'image|max:2048' // validação das fotos, ex: tamanho max 2MB
        ]);

        $data = $request->only(['nome', 'whatsapp', 'marca', 'modelo', 'ano']);

        // Pega as fotos, se enviadas
        $fotos = $request->file('fotos'); // já é array se usar fotos[]

        // Exemplo básico: criar o corpo do email
        $mensagem = "Novo orçamento:\n";
        $mensagem .= "Nome: {$data['nome']}\n";
        $mensagem .= "Whatsapp: {$data['whatsapp']}\n";
        $mensagem .= "Marca: {$data['marca']}\n";
        $mensagem .= "Modelo: {$data['modelo']}\n";
        $mensagem .= "Ano: {$data['ano']}\n";
        $mensagem .= "Fotos anexadas: " . ($fotos ? count($fotos) : 0) . "\n";

        Mail::raw($mensagem, function ($message) use ($data, $fotos) {
            $message->to(env('MAIL_FROM_ADDRESS'))
                    ->subject('Novo orçamento recebido');


            if ($fotos) {
                foreach ($fotos as $foto) {
                    $message->attach($foto->getRealPath(), [
                        'as' => $foto->getClientOriginalName(),
                        'mime' => $foto->getMimeType(),
                    ]);
                }
            }
        });

        return response()->json(['success' => true, 'message' => 'Orçamento enviado e email disparado.']);
    }
}
