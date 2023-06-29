<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;


class ContratoController extends Controller
{
    public function index() {
        $data = $_POST;

        // Crie uma instância do Dompdf
        $dompdf = new Dompdf();

        // Renderize a página PHP em uma string
        $views = [
            'relatorio.contratoonepage',
        ];

        $html = '';
        $total = 0;
        foreach ($views as $view) {
            $html .= View::make($view, ['data' => $data])->render();
            $total++;
            if($total != 4){
                $html .= '<div style="page-break-before:always;"></div>'; // Adicione uma quebra de página entre as views
            }
        }

        // Carregue o HTML no Dompdf
        $dompdf->loadHtml($html);

        // Defina o tamanho e a orientação da página (opcional)
        $dompdf->setPaper('A4', 'portrait');

        // Renderize o PDF
        $dompdf->render();

        // Salve o PDF em um arquivo ou envie para o navegador
        $dompdf->stream('contrato.pdf');

    }
}

