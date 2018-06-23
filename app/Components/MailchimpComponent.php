<?php

namespace App\Components;

use Mailchimp;


class MailchimpComponent extends Mailchimp
{
    public $root = 'https://api.mailchimp.com/2.0';
    public $jsonSuffix = '.json';
    public $instanceVersion = 2;

    public function call($url, $params = [])
    {
        if ($this->instanceVersion === 2) {
            $params['apikey'] = $this->apikey;
        }
        $params = json_encode($params);
        $ch     = $this->ch;

        curl_setopt($ch, CURLOPT_URL, $this->root . $url . $this->jsonSuffix);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        if ($this->instanceVersion === 3) {
            curl_setopt($ch, CURLOPT_USERPWD, "user:" . $this->apikey);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);

        $start = microtime(true);
        $this->log('Call to ' . $this->root . $url . '.json: ' . $params);
        if($this->debug) {
            $curl_buffer = fopen('php://memory', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $curl_buffer);
        }

        $response_body = curl_exec($ch);

        $info = curl_getinfo($ch);
        $time = microtime(true) - $start;
        if($this->debug) {
            rewind($curl_buffer);
            $this->log(stream_get_contents($curl_buffer));
            fclose($curl_buffer);
        }
        $this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
        $this->log('Got response: ' . $response_body);

        if(curl_error($ch)) {
            throw new Mailchimp_HttpError("API call to $url failed: " . curl_error($ch));
        }
        $result = json_decode($response_body, true);

        if(floor($info['http_code'] / 100) >= 4) {
            throw $this->castError($result);
        }

        return $result;
    }

    public function createList($params)
    {
        $this->jsonSuffix = '';
        $this->setV3Root();
        return $this->call('lists', $params);
    }

    public function updateList($id, $params)
    {
        $this->jsonSuffix = '';
        $this->setV3Root();
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        return $this->call('lists/' . $id, $params);
    }

    public function deleteList($id)
    {
        $this->jsonSuffix = '';
        $this->setV3Root();
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->call('lists/' . $id);
    }


    public function createSubscriber($id, $email)
    {
        if (!is_array($email)) {
            $email = [$email];
        }
        return $this->lists->batchSubscribe($id, $email);
    }

    public function updateSubscriber($id, $email)
    {
        if (!is_array($email)) {
            $email = [$email];
        }
        return $this->lists->batchSubscribe($id, $email, true, true);
    }

    public function deleteSubscriber($id, $email)
    {
        if (!is_array($email)) {
            $email = [$email];
        }
        return $this->lists->batchUnsubscribe($id, $email);
    }

    public function setV3Root()
    {
        $this->root = 'https://api.mailchimp.com/3.0/';
        $this->instanceVersion = 3;
        $dc           = "us1";

        if (strstr($this->apikey, "-")){
            list($key, $dc) = explode("-", $this->apikey, 2);
            if (!$dc) {
                $dc = "us1";
            }
        }

        $this->root = str_replace('https://api', 'https://' . $dc . '.api', $this->root);
        $this->root = rtrim($this->root, '/') . '/';
    }
}