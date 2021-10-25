<?php

if (is_super_admin()) {

    $client_key = '3MVG9szVa2RxsqBakjwNOHMIqqZ5zUOhCGA4w0euVN.JVvM7HuDdHd0B.CasuYhU5j.13tZ83_gEN5bR..n28';
    $client_secret = 'D1D6FE3C469C84A6A09925733733B3D6EE4D111BE487C71A14A85A592F5AE3ED';
    $callback = home_url('salesforce-api-callback/');

    if (empty($_GET['code'])) {

        echo '<a href="https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=' . $client_key . '&redirect_uri=' . $callback . '">Click to Authorize</a>';
    } else {

        $code = $_GET['code'];


        $endpoint = 'https://login.salesforce.com/services/oauth2/token?grant_type=authorization_code&redirect_uri=' . $callback . '&client_id=' . $client_key . '&client_secret=' . $client_secret . '&code=' . $code;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        @curl_close($ch);
        
        update_option('salesforce_token', $response);
        
        echo 'Token Saved';
        
    }
}