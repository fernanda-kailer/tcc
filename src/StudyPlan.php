<?php
class StudyPlan {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function generatePlan($subject, $content, $studyTime) {
        // Configuração da API
        $apiKey = getenv('OPENAI_API_KEY');
        $url = 'https://api.openai.com/v1/chat/completions';
    
        // Dados para enviar - formato adequado para o modelo de chat
        $data = [
            'model' => 'gpt-4o-mini', 
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Você é um assistente que responde sempre em português.'
                ],
                [
                    'role' => 'user',
                    'content' => "Crie um plano de estudos para a matéria: $subject. 
                    O conteúdo a ser estudado é: $content. O usuário tem $studyTime minutos disponíveis para estudar. Por favor, responda em português."
                ]
            ],
            'max_tokens' => 1000,
        ];
    
        // Configuração do cURL
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
        ];
    
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            return; 
        }
    
        curl_close($ch);
    
        
        $data = json_decode($response, true);
    
        
        if (isset($data['choices'][0]['message']['content'])) {
            $plan = $data['choices'][0]['message']['content'];
    
            $plan = preg_replace('/^Claro! Aqui está um plano de estudos.*?(\n|$)/s', '', $plan);
            $plan = preg_replace('/^Claro! Abaixo está um plano de estudos.*?(\n|$)/s', '', $plan);
            $plan = preg_replace('/Bom estudo!.*?(\n|$)/s', '', $plan);
            $plan = str_replace(['#', '*'], '', $plan);
    
            // Criar HTML para exibição visual
            return $this->formatResponse($plan);
        } else {
            return 'Erro: Não foi possível gerar o plano de estudos.';
        }
    }
    
    // Função para formatar a resposta com HTML
    private function formatResponse($plan) {
    
        $html = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Plano de Estudos</title>
            <style>
                body { font-family: 'Arial', sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
                pre{padding:2%;}
                h1 { text-align: center; color: #6A0DAD; font-weight: bold; }
                h2 { margin-top: 20px; color: #6A0DAD; font-weight: bold; }
                p { line-height: 1.6; color: #666; }
                ul { list-style-type: disc; padding-left: 20px; color: #555; }
                .highlight { background-color: #EDE7F6; padding: 10px; border-left: 4px solid #6A0DAD; margin: 10px 0; border-radius: 5px; }
                .block-title { color: #6A0DAD; font-weight: bold; }
                .subtitle { color: #6A0DAD; font-size: 1.2em; font-weight: bold; }
                .block { margin-top: 10px; }
            </style>
        </head>
        <body>
            
                <h1>Plano de Estudos</h1>
                ";
    
        $plan = nl2br($plan);
        $html .= "<div class='highlight'>$plan</div>";

        $html .= "
             </body>
        </html>";
    
        return $html;
    }
    
    
    
    
    
}
