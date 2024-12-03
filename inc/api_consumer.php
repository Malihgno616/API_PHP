<?php 

class ApiConsumer
{
    // Método privado para consumir a API
    private function api($endpoint, $method = 'GET', $post_field = [])
    {
        $curl = curl_init();
        $url = "https://restcountries.com/v2/" . $endpoint; // Usar o endpoint correto

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 180,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "Accept: */*"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($err) {
            return "cURL Error #: " . $err;
        } else {
            if ($http_code !== 200) {
                return "Erro na API: Status HTTP " . $http_code;
            }             
            $decoded_response = json_decode($response, true);
            if ($decoded_response === null) {
                return "Erro ao decodificar JSON: " . json_last_error_msg();
            }
            return $decoded_response;
        }
    }

    // Método público para retornar todos os países com bandeiras
    public function get_all_countries(): array|string
    {
        $results = $this->api('all'); // Endpoint para obter todos os países

        // Verificar se a resposta é um erro
        if (is_string($results)) {
            return $results;
        }

        // Verificar se a resposta é um array
        if (!is_array($results)) {
            return "Erro: Resposta da API não é um array.";
        }

        $countries = [];
        
        foreach ($results as $result) {
            // Ajustar o acesso ao nome do país e à bandeira
            $countries[] = [
                'name' => $result['name'] ?? "Nome não encontrado",
                'flag' => $result['flags']['png'] ?? null // URL da bandeira em formato PNG
            ];
        }

        return $countries;
    }

    // Método público para retornar informações de um país específico
    public function get_country($country_name)
    {
        // Usar o endpoint apropriado para obter um país pelo nome
        $results = $this->api("name/" . urlencode($country_name)); // Encode para garantir que o nome do país é seguro para URL

        // Verificar se a resposta é um erro
        if (is_string($results)) {
            return $results;
        }

        // Retornar o primeiro resultado, pois a API pode retornar múltiplos resultados
        return $results[0] ?? null; // Se não houver resultado, retorna null
    }
}

?>