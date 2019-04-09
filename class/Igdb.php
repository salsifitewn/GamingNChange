<?php
class Igdb {
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getGames(){
        $data = $this->callAPI("platforms");
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        /* return [
            'temp' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'date' => new DateTime()
        ]; */
    }
    private function callAPI(string $endpoint): ?array
    {
        $curl = curl_init("https://api-v3.igdb.com/{$endpoint}");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_CAINFO => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'COMODOECCCertificationAuthority.crt', //recuperer sur firefox certifat racine
            CURLOPT_TIMEOUT => 1,
            CURLOPT_HTTPHEADER => [
                "user-key:{$this->apiKey}",
                "Accept: application/json"
            ],
            CURLOPT_POSTFIELDS => "fields name; limit 20", //sql-like query
            CURLOPT_VERBOSE => true
        ]);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return null;
        }
        return json_decode($data, true);
    }
    
}