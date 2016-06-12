<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.06.2016
 * Time: 2:19
 */
class api_class extends base
{

    public function sendTest()
    {
        $url = 'https://api.nexmo.com/verify/json';//?api_key=' . API_KEY . '&api_secret=' . API_SECRET . '&number=79263335708&brand=NexmoVerifyTest';
        $params = array(
            'number' => '79263335708',
            'brand' => 'NexmoVerifyTest'
        );
        return $this->makeApiCall($params, 'GET', $url);
    }

    /**
     * @param string $to
     * @param string $text
     * @param array $params
     * @return bool
     */

    public function sendMessage($to, $text, $params = [])
    {
        $params['to'] = $to;
        $params['text'] = $text;
        $res = $this->makeApiCall($params);
        if ($res['status'] == 0) {
            return true;
        } else {
            $this->writeLog("Delivery Error", "Error {$res['status']} {$res['error-text']}");
            return false;
        }
    }

    public function __construct()
    {

    }

    public function makeApiCall($params = [], $method = 'GET', $url = API_URL)
    {
        $params['api_key'] = API_KEY;
        $params['api_secret'] = API_SECRET;
//        $params['from'] = API_SENDER;
        $url .= '?' . http_build_query($params);
        $this->writeLog('test', $url);
//        $headers = array(
//            "User-Agent: php-tutorial/1.0",
//            "Authorization: Bearer " . $this->access_token,
//            "Accept: application/json",
//        );
        $curl = curl_init($url);
        switch($method) {
            case "GET":
                break;
            case "POST":
                $headers[] = "Content-Type: application/json";
                curl_setopt($curl, CURLOPT_POST, true);
                $params = $params ? json_encode($params) : json_encode($params, JSON_FORCE_OBJECT);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case "PATCH":
                $headers[] = "Content-Type: application/json";
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                self::writeLog('EXCHANGE', 'INVALID METHOD ' . $method);
                exit;
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        $this->writeLog('test', $response);
        return json_decode($response, true);
    }
}