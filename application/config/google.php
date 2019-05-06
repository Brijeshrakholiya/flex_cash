<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = '428607801685-7s1rcvgo4q183gk6lcebaa2p5r5gg5bm.apps.googleusercontent.com'; 
$config['google']['client_secret']    = 'seMqERYuJBfrDvF9PO4QwvlI'; // 
$config['google']['redirect_uri']     = base_url().'auth/web_social_login';
$config['google']['application_name'] = 'FlexCash';
$config['google']['api_key']          = 'AIzaSyAlsiphcebzHqQ8TU8ikz1wi86LyrhhvFE';
$config['google']['scopes']           = array();