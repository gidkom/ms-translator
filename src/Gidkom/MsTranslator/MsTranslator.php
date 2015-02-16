<?php

namespace Gidkom\MsTranslator;

class MsTranslator
{
    public $client_id;
    public $client_secret;
    
    public function __construct($cid, $secret)
    {
        $this->client_id = $cid;
        $this->client_secret = $secret;
    }
    
    /**
     * Get access token
     *
     * @return string 
     */
    public function get_access_token()
    {	
        # if access token is not expired and is stored in COOKIE
        if(isset($_COOKIE['bing_access_token']))
                return $_COOKIE['bing_access_token'];

        # Get a 10-minute access token for Microsoft Translator API.
        $url = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13';
        $postParams = 'grant_type=client_credentials&client_id='.urlencode($this->client_id).
        '&client_secret='.urlencode($this->client_secret).'&scope=http://api.microsofttranslator.com';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $rsp = curl_exec($ch); 
        $rsp = json_decode($rsp);
        $access_token = $rsp->access_token;
        
        setcookie('bing_access_token', $access_token, $rsp->expires_in);
        
        return $access_token;
    }
    /**
     * Translate text to a specified language
     *
     * @param string $text
     * @param string $from  language of text
     * @param string $to    language to be translated to
     * @return string       Translated text
     */
    public function translate($text, $from, $to)
    {
        $access_token = $this->get_access_token();
        $url = 'http://api.microsofttranslator.com/V2/Http.svc/Translate?text='.urlencode($text).'&from='.$from.'&to='.$to;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:bearer '.$access_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $rsp = curl_exec($ch); 
        
        preg_match_all('/<string (.*?)>(.*?)<\/string>/s', $rsp, $matches);
	
        return $matches[2][0];
    }
            
    /**
     * Translate text to specified languages
     *
     * @param string $text
     * @param string $from  language of text
     * @param array $tos     languages to be translated to
     * @return array        Translations of the text to given languages
     */
    public function multiTranslate($text, $from, $tos)
    {        
        $access_token = $this->get_access_token();

        $result = array();
        
        $result[$from] = $text;
        
        foreach($tos as $to)
        {
            $url = 'http://api.microsofttranslator.com/V2/Http.svc/Translate?text='.urlencode($text).'&from='.$from.'&to='.$to;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:bearer '.$access_token));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
            $rsp = curl_exec($ch); 
            
            preg_match_all('/<string (.*?)>(.*?)<\/string>/s', $rsp, $matches);

            $result[$to] = $matches[2][0];
        }
        
        return $result;
    }
}