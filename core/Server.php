<?php
require "Interface/I_ServerMethod.php";
/**
 * Server Class
 * @author lintangtimur lintangtimur915@gmail.com
 * @see http://github.com/lintangtimur CheckServer
 */
class Server implements IServerMethod
{
    /**
   * Port
   * @var array
   */
    private $ports = [];

    /**
     * Server List
     * @var array
     */
    private $servers = [];

    /**
     * Tampung hasil decode json config
     * @var array
     */
    private $json_decode_result;

    /**
     * GetStatus
     * @param  string $url ex:google.com
     * @return bool
     */
    public function getStatus($url)
    {
        $timeout = 10;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $http_respond = curl_exec($ch);
        $http_respond = trim(strip_tags($http_respond));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (($http_code == "200") || ($http_code == "302")) {
            return true;
        } else {
            return false;
        }
        curl_close();
    }

    public function addServer($config)
    {
        $string = file_get_contents("conf.json");
        $json_decode = json_decode($string, true);

        $this->json_decode_result = $json_decode;

        return $this;
    }

    /**
     * Parse Array
     * @return array
     */
    public function parse()
    {
        foreach ($this->json_decode_result['server'] as $key => $value) {
            $this->servers[] = $value;
        }
        foreach ($this->json_decode_result['port'] as $service => $port) {
            $this->ports[$service] = $port;
        }
    }

    /**
     * Check online or not
     * @param  string $domain ex:google.com
     * @return bool
     */
    public function checkOnline($domain)
    {
        $curlInit = curl_init($domain);
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curlInit, CURLOPT_HEADER, true);
        curl_setopt($curlInit, CURLOPT_NOBODY, true);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

       //get answer
       $response = curl_exec($curlInit);

        curl_close($curlInit);
        if ($response) {
            return true;
        }

        return false;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function updown()
    {
        foreach ($this->servers as $index => $server) {
            if ($this->checkOnline($server)) {
                echo "$server : ONLINE"."<br>";
            } else {
                echo "$server : DOWN "."<br>";
            }
        }
    }

    /**
     * Check port is open or not
     * @return mixed
     */
    public function checkOpenPort()
    {
        foreach ($this->servers as $index => $server) {
            foreach ($this->ports as $services => $port) {
                $conn = @fsockopen($server, $port, $errno, $errstr, 5);
                if (!$conn) {
                    //Port is blocked
                    echo "$server with port $port : CLOSED"."<br>";
                } else {
                    //Port is open
                    echo "$server with port $port : OPEN"."<br>";
                }
            }
            echo "<br>";
        }
    }
}
