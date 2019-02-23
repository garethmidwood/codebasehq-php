<?php

namespace GarethMidwood\CodebaseHQ;

use GarethMidwood\CodebaseHQ\Project;

class CodebaseHQConnector
{
    private $apiUser;
    private $apiKey;
    private $apiHostname;
    private $apiUrl;

    /**
     * Constructor
     * @param string $apiUser 
     * @param string $apiKey 
     * @param string $apiHostname 
     * @param string $apiUrl
     * @return void
     */
    public function __construct(
        $apiUser,
        $apiKey,
        $apiHostname,
        $apiUrl = 'https://api3.codebasehq.com'
    ) {
        $this->apiUser = $apiUser;
        $this->apiKey = $apiKey;
        $this->apiHostname = $apiHostname;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Makes a post request to the given api endpoint url
     * @param string $endpointUrl 
     * @param string $data XML formatted string
     * @return string
     */
    protected function post($endpointUrl, $data)
    {
        return $this->request($endpointUrl, $data);
    }

    /**
     * Makes a get request to the given api endpoint url
     * @param string $endpointUrl
     * @return string
     */   
    protected function get($endpointUrl)
    {
        return $this->request($endpointUrl);
    }

    /**
     * Makes a request to the given api url and returns the XML response object
     * @param string $endpointUrl 
     * @param string|null $data XML formatted string
     * @throws \Exception if curl request fails
     * @return \SimpleXMLElement
     */
    private function request($endpointUrl, $data = null)
    {
        $ch = curl_init($this->apiUrl . $endpointUrl);

        $headers = array(
            'Content-Type: application/xml',
            'Accept: application/xml',
            'Authorization: Basic ' . base64_encode($this->apiUser . ':'. $this->apiKey)
        );

        if (isset($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('Error making curl request to ' . $this->apiUrl . $endpointUrl . ' message: ' . curl_error($ch));
        }

        curl_close($ch);

        return $this->responseToArray($response);
    }


    /**
     * Converts an API response into an associative array, via XML
     * @param string $response 
     * @return array
     */
    private function responseToArray($response)
    {
        $xml = simplexml_load_string($response, 'SimpleXMLIterator', LIBXML_NOCDATA);

        if ($xml === false) {
            throw new \Exception('Error converting CodebaseHQ response to xml');
        }

        $array = json_decode(json_encode((array)$xml), true);

        return $array;
    }
}
