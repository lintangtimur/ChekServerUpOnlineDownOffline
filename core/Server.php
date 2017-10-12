<?php
namespace Stelserve;

use Stelserve\IServerMethod;
use Stelserve\Exception\InvalidJSONException;

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
    private $JSONDecodeResult;

    /**
     * GetStatus
     * @param  string $url ex:google.com
     * @return bool
     */
    public function isSucceded($url)
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

    /**
     * Menambah server dalam format file json
     * @param string $config json file yang berisi config
     * @return $this
     */
    public function addServer($config)
    {
        try {
            if ($this->isJSON($config)) {
                $string = file_get_contents($config);
            } else {
                throw new InvalidJSONException($config);
            }
        } catch (InvalidJSONException $e) {
            die($e->getMessage());
        }
        $json_decode = json_decode($string, true);

        $this->JSONDecodeResult = $json_decode;

        return $this;
    }

    /**
     * Check if is JSON
     * @param  string  $string config
     * @return bool
     */
    public function isJSON($string)
    {
        $json = file_get_contents($string);
        $json = json_decode($json);
        if (json_last_error() === JSON_ERROR_NONE) {
            return true;
        }

        return false;
    }

    /**
     * Parse Array
     * @return array
     */
    public function parse()
    {
        foreach ($this->JSONDecodeResult['server'] as $key => $value) {
            $this->servers[] = $value;
        }
        foreach ($this->JSONDecodeResult['port'] as $service => $port) {
            $this->ports[$service] = $port;
        }
    }

    /**
     * Check online or not
     * @param  string $domain ex:google.com
     * @return bool
     */
    public function isOnline($domain)
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

    /**
     * Get Server
     * @return array
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Get Ports
     * @return array
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * UPDOWN
     * @return void
     */
    public function updown()
    {
        foreach ($this->servers as $index => $server) {
            if ($this->isOnline($server)) {
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
