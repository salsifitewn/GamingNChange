<?php

namespace App;

class Igdb
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getGame(int $gameid): ?array
    {
        $data = $this->callAPI("games", "fields 
                name,
                platforms.platform_logo.url,
                first_release_date,
                cover.url,
                rating,
                summary,
                involved_companies.company.name,
                involved_companies.developer,
                involved_companies.publisher,
                release_dates.platform,
                release_dates.date,
                screenshots.url;
                where id=$gameid");
        return $data;
    }

    public function getLastGames(): ?array
    {
        //$time=time()-
        $data = $this->callAPI("games", "fields name,platforms.platform_logo.url,first_release_date,cover.url,rating,summary,involved_companies.company.name,involved_companies.developer,involved_companies.publisher,release_dates.platform,release_dates.date,screenshots.url;where rating>90 & involved_companies>0 & cover>0 & category=0;limit 30");
        /* return [
            'temp' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'date' => new DateTime()
        ]; */

        return $data;
    }
    public function getPlatforms(array $platform_ids): ?array
    {
        sort($platform_ids);
        
        //$min = min($platform_ids);
        //$max = max($platform_ids);
        $platformsdata = [];
        
        while (!empty($platform_ids)){
            $limit = min(count($platform_ids), 10);
            $idString="(";
            for ($i=0; $i < $limit-1; $i++) { 
                $idString.=$platform_ids[$i].",";
            }
            //var_dump($platform_ids);
            $idString.=$platform_ids[$limit-1].")";
            $platform_ids=array_slice($platform_ids,$limit,count($platform_ids));
            $platformsdata=array_merge($platformsdata,$this->callAPI("platforms", "fields name,platform_logo.url;where id=$idString;limit $limit;"));
        } 
        //dd($platform_ids);
        return $platformsdata;
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
    public static function getCover(string $url,string $size='thumb'): string
    {
        return str_replace("thumb", $size, $url);
    }
    public function searchGames(string $gameName): array
    {
        $data = $this->callAPI("games", "fields name,platforms.name,platforms.platform_logo.url,first_release_date,cover.url,summary;search \"$gameName\";where first_release_date>0 & platforms!= null; ");
        return $data;
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
