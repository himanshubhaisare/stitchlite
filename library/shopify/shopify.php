<?php

/**
 * Class ShopifyClient
 */
class ShopifyClient {

    /**
     * @var
     */
    private $shop_domain;
    /**
     * @var
     */
    private $token;
    /**
     * @var
     */
    private $api_key;
    /**
     * @var
     */
    private $secret;
    /**
     * @var bool
     */
    private $is_private_app;
    /**
     * @var null
     */
    private $last_response_headers = null;

    /**
     * @param $shop_domain
     * @param $token
     * @param $api_key
     * @param $secret
     * @param bool $is_private_app
     */
    public function __construct($shop_domain, $token, $api_key, $secret, $is_private_app=false) {
        $this->name = "ShopifyClient";
        $this->shop_domain = $shop_domain;
        $this->token = $token;
        $this->api_key = $api_key;
        $this->secret = $secret;
        $this->is_private_app = $is_private_app;
    }

    /**
     * @return string
     */
    public function getAppInstallUrl() {
        return "http://{$this->shop_domain}/admin/api/auth?api_key={$this->api_key}";
    }

    /**
     * @param $timestamp
     * @param $signature
     * @return bool
     */
    public function isAppInstalled($timestamp, $signature) {
        return (md5("{$this->secret}shop={$this->shop_domain}t={$this->token}timestamp={$timestamp}") === $signature);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function callsMade()
    {
        return $this->shopApiCallLimitParam(0);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function callLimit()
    {
        return $this->shopApiCallLimitParam(1);
    }

    /**
     * @param $response_headers
     * @return int
     */
    public function callsLeft($response_headers)
    {
        return $this->callLimit() - $this->callsMade();
    }

    /**
     * @param $method
     * @param $path
     * @param array $params
     * @return array|mixed
     * @throws ShopifyApiException
     * @throws ShopifyCurlException
     */
    public function call($method, $path, $params=array())
    {
        $password = $this->is_private_app ? $this->secret : md5($this->secret.$this->token);
        $baseurl = "https://{$this->api_key}:$password@{$this->shop_domain}/";

        $url = $baseurl.ltrim($path, '/');
        $query = in_array($method, array('GET','DELETE')) ? $params : array();
        $payload = in_array($method, array('POST','PUT')) ? stripslashes(json_encode($params)) : array();
        $request_headers = in_array($method, array('POST','PUT')) ? array("Content-Type: application/json; charset=utf-8", 'Expect:') : array();

        $response = $this->curlHttpApiRequest($method, $url, $query, $payload, $request_headers);
        $response = json_decode($response, true);

        if (isset($response['errors']) or ($this->last_response_headers['http_status_code'] >= 400))
            throw new ShopifyApiException($method, $path, $params, $this->last_response_headers, $response);

        return (is_array($response) and (count($response) > 0)) ? array_shift($response) : $response;
    }

    /**
     * @param $method
     * @param $url
     * @param string $query
     * @param string $payload
     * @param array $request_headers
     * @return mixed
     * @throws ShopifyCurlException
     */
    private function curlHttpApiRequest($method, $url, $query='', $payload='', $request_headers=array())
    {
        $url = $this->curlAppendQuery($url, $query);
        $ch = curl_init($url);
        $this->curlSetopts($ch, $method, $payload, $request_headers);
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($errno) throw new ShopifyCurlException($error, $errno);

        list($message_headers, $message_body) = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
        $this->last_response_headers = $this->curlParseHeaders($message_headers);

        return $message_body;
    }

    /**
     * @param $url
     * @param $query
     * @return string
     */
    private function curlAppendQuery($url, $query)
    {
        if (empty($query)) return $url;
        if (is_array($query)) return "$url?".http_build_query($query);
        else return "$url?$query";
    }

    /**
     * @param $ch
     * @param $method
     * @param $payload
     * @param $request_headers
     */
    private function curlSetopts($ch, $method, $payload, $request_headers)
    {
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'HAC');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ('GET' == $method)
        {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }
        else
        {
            curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, $method);
            if (!empty($request_headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
            if (!empty($payload))
            {
                if (is_array($payload)) $payload = http_build_query($payload);
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $payload);
            }
        }
    }

    /**
     * @param $message_headers
     * @return array
     */
    private function curlParseHeaders($message_headers)
    {
        $header_lines = preg_split("/\r\n|\n|\r/", $message_headers);
        $headers = array();
        list(, $headers['http_status_code'], $headers['http_status_message']) = explode(' ', trim(array_shift($header_lines)), 3);
        foreach ($header_lines as $header_line)
        {
            list($name, $value) = explode(':', $header_line, 2);
            $name = strtolower($name);
            $headers[$name] = trim($value);
        }

        return $headers;
    }

    /**
     * @param $index
     * @return int
     * @throws Exception
     */
    private function shopApiCallLimitParam($index)
    {
        if ($this->last_response_headers == null)
        {
            throw new Exception('Cannot be called before an API call.');
        }
        $params = explode('/', $this->last_response_headers['http_x_shopify_shop_api_call_limit']);
        return (int) $params[$index];
    }
}

/**
 * Class ShopifyCurlException
 */
class ShopifyCurlException extends Exception { }

/**
 * Class ShopifyApiException
 */
class ShopifyApiException extends Exception
{
    /**
     * @var string
     */
    protected $method;
    /**
     * @var int
     */
    protected $path;
    /**
     * @var Exception
     */
    protected $params;
    /**
     * @var
     */
    protected $response_headers;
    /**
     * @var
     */
    protected $response;

    /**
     * @param string $method
     * @param int $path
     * @param Exception $params
     * @param $response_headers
     * @param $response
     */
    function __construct($method, $path, $params, $response_headers, $response)
    {
        $this->method = $method;
        $this->path = $path;
        $this->params = $params;
        $this->response_headers = $response_headers;
        $this->response = $response;

        parent::__construct($response_headers['http_status_message'], $response_headers['http_status_code']);
    }

    /**
     * @return string
     */
    function getMethod() { return $this->method; }

    /**
     * @return int
     */
    function getPath() { return $this->path; }

    /**
     * @return Exception
     */
    function getParams() { return $this->params; }

    /**
     * @return mixed
     */
    function getResponseHeaders() { return $this->response_headers; }

    /**
     * @return mixed
     */
    function getResponse() { return $this->response; }
}