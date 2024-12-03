<?php 

class ApiConsumer
{
    // Método privado para consumir a API
    private function api($endpoint, $method = 'GET', $post_field = [])
    {
        $curl = curl_init();
        $url = "https://restcountries.com/v2/all";

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
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


    // Método público para retornar todos os países
    public function get_all_countries(): array|string
    {
        $results = $this->api(endpoint: 'all');

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
            // Ajustar o acesso ao nome do país
            if (isset($result['name'])) {
                $countries[] = $result['name'];
            } else {
                $countries[] = "Nome não encontrado";
            }
        }

        return $countries;
    }

    public function get_country($country_name)
    {
        return $this->api($country_name); // Passa o nome do país como parâmetro
    }


}

?>
