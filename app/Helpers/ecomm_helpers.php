<?php

function getSystemId(){
        return '1';
    }
function getApiUrl(){
        return "http://sws_retail.lar/api/";
    }
function getUsrToken(){
    return 'eyJpdiI6Inh2MUdcL3ZmWllJK1VhRkpBTWNtcDVBPT0iLCJ2YWx1ZSI6IkpaeWt3SHJrUDUxMWFCK1FzRks3WEtVb2VDN0p4OTZWb3VDSW5uWEVnQnNKV0UydVZORFh2cGZsXC9DR1g4aWVhIiwibWFjIjoiOTM1NWMyMzI2YmI4ZGU3NTIyOWMwZDMzOTM0NjBjM2E2MGZkYzhiOTdmZWI5ZjdlMGJlNDBlMWFjOTlkNjBmZCJ9';
}            
function getApiHeader(){
    $api_header = [
                'Content-Type'=>'application/json', 
                'Accept'=>'application/json',
                'Usr-token'=>getUsrToken()
            ];
    return $api_header;
}
if (!function_exists('validation_state')) {
    /**
     * validation state helper
     *
     * @param \Illuminate\Support\ViewErrorBag $errors
     * @param array|string                     $names
     * @param string                           $context
     * @return string
     */
    function validation_state(Illuminate\Support\ViewErrorBag $errors, $names, $context = 'has-danger')
    {
        //normalize input to array
        $names = ! is_array($names) ? [$names] : $names;
        //check if error exists
        foreach ($names as $name) {
            if ($errors->has($name)) {
                return $context;
            }
        }
        //no error
        return '';
    }
}

if (!function_exists('flashMessage')) {
    /**
     * set modal info
     *
     * set the title, message, and any fields for the modal
     *
     * @param string $title
     * @param string $message
     * @param array  $fields
     */
    function flashMessage($title, $message, $fields = [])
    {
        session()->flash('modal', [
            'title'   => $title,
            'message' => $message,
            'fields'  => $fields,
        ]);
    }
}

function getDetails($url, $data=null){
    
    $curl = curl_init();
    $URL  = getApiUrl() . $url;
    
    $data['system_id'] = getSystemId();
    curl_setopt_array($curl, array(
        CURLOPT_URL                 => $URL,
        CURLOPT_RETURNTRANSFER      => true,
        CURLOPT_ENCODING            => "",
        CURLOPT_MAXREDIRS           => 10,
        CURLOPT_TIMEOUT             => 30000,
        CURLOPT_HTTP_VERSION        => CURL_HTTP_VERSION_1_1,
        CURLOPT_HEADER              => false,
        CURLOPT_POST                => 1,
        CURLOPT_RETURNTRANSFER      => true,
        CURLOPT_CUSTOMREQUEST       => "GET",
        CURLOPT_POSTFIELDS          => json_encode($data),
        CURLOPT_HTTPHEADER          => getApiHeader()
    ));

    $result     = curl_exec($curl);
    $err        = curl_error($curl);
    curl_close($curl);
    dd($result);
    return $result->getBody()->getContents();
}

function postDetails($url, $data=null){    
    $curl = curl_init();
    $URL  = getApiUrl() . $url;
    $data->system_type = $system_type;
    curl_setopt_array($curl, array(
        CURLOPT_URL                 => $URL,
        CURLOPT_RETURNTRANSFER      => true,
        CURLOPT_ENCODING            => "",
        CURLOPT_MAXREDIRS           => 10,
        CURLOPT_TIMEOUT             => 30000,
        CURLOPT_HTTP_VERSION        => CURL_HTTP_VERSION_1_1,
        CURLOPT_HEADER              => false,
        CURLOPT_POST                => 1,
        CURLOPT_RETURNTRANSFER      => true,
        CURLOPT_CUSTOMREQUEST       => "POST",
        CURLOPT_POSTFIELDS          => json_encode($data),
        CURLOPT_HTTPHEADER          => getApiHeader()
    ));

    $result     = curl_exec($curl);
    // $err        = curl_error($curl);
    curl_close($curl);
    return $result->getBody()->getContents();
}

function getAvailability($url, $data=null)
{

}