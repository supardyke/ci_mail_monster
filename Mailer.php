<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer
{
    // message subject
    private $subject;
    // email to receive the message
    private $email;
    // message to be sent
    private $message;
    // Message sender ie Admin,Support
    private $from;

    public function send_mail($subject,$email,$message){
        // mail sent using php inbuilt mailer
        mail($email,$subject,$message);
    }

    public function send_mail_html($subject,$email,$message,$from){
        // get headers using from and base url
        $headers = $this->headers($from,$this->get_base_url());
        // mail sent using php inbuilt mailer
        mail($email,$subject,$message,$headers);
    }
    public function headers($from,$url){

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // to get the business name we use example for domain example.com
        $domain_name = $this->get_domain_name($this->filter_url($this->get_base_url()));
                    
        // More headers
        $headers .= "From:".$domain_name." ".$from." <".$from."@".$url.">" . "\r\n";
        //$headers .= "Cc: Info@".$url." " . "\r\n";

        return $headers;
    }

    public function get_base_url(){
        // load url from the server name 
        $server = $_SERVER['SERVER_NAME'];
        // filter base url
        $the_base_url = $this->filter_url($server);
        return $the_base_url;
    }

    public function filter_url($url){    
        // we have to filter the url to avoid mail sending errors    
        $url = str_replace("www.", "", $url );
        $url = str_replace("http://", "", $url );
        $url = str_replace("https://", "", $url );
        $url = str_replace("/", "", $url );
        return $url;
    }

    public function get_domain_name($url){    
        // we have to filter the url to retrieve a name for the platform  
        $url_e = explode(".", $url);
        $platform_name = $url_e[0];
        return $platform_name;
    }
}
