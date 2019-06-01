<?php

namespace App;

class Igdb
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }


    public function getGameRange(string $gameName)
    {
        $data = $this->callAPI("games");
    }


    public function getLastGames(): ?array
    {
        //$time=time()-
        $data = $this->callAPI("games", "fields name,first_release_date,cover.url,rating,summary,involved_companies;where rating>90 & involved_companies>0 & cover>0 & category=0;limit 50");
        /* return [
            'temp' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'date' => new DateTime()
        ]; */

        return $data;
    }
    public function getPublisher(string $publisherid): ?array
    {
        //$publishers = $this->callAPI("involved_companies", "fields company;where game=$game_id & publisher=true;");
        $publishers = $this->callAPI("company", "fields name;where id=($publisherid);");
        return $publishers;
       /*  $publisherid = $publishers[0]['company']??null;
        if(!is_null($publisherid))
        return $this->callAPI("companies", "fields name;where id=$publisherid;")[0]['name'];
        return null; */
        /*  echo '<pre>';
        dd($data);
        echo '</pre>'; */
    }
    public static function getCover(string $url): string
    {
        return str_replace("thumb", "cover_big", $url);
    }

    private function callAPI(string $endpoint, string $post_fields): ?array
    {
        $curl = curl_init("https://api-v3.igdb.com/{$endpoint}");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_CAINFO => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'COMODOECCCertificationAuthority.crt', //recuperer sur firefox certifat racine
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_HTTPHEADER => [
                "user-key:{$this->apiKey}",
                "Accept: application/json"
            ],
            CURLOPT_POSTFIELDS => "{$post_fields};", //sql-like query
            CURLOPT_VERBOSE => true
        ]);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return null;
        }
        return json_decode($data, true);
    }
}
