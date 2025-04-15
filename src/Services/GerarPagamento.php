<?php

namespace App\Services;

use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class GerarPagamento {

    public function generatePayment(string $method, float $price, string $email){

        MercadoPagoConfig::setAccessToken("APP_USR-274381405765033-031216-287b60210bb2fca4b6c0e9150bc4e74e-1509949497");
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $client = new PaymentClient();

        try{

            $request = [
                "transaction_amount" => $price,
                "description" => "description",
                "payment_method_id" => $method,
                "payer" => [
                    "email" => $email,
                ]
            ];

            $request_options = new RequestOptions();
            $request_options->setCustomHeaders(["X-Idempotency-Key: " . uniqid()]);

            $payment = $client->create($request, $request_options);

            $data = json_decode(json_encode($payment), true);

            return [
                'pix_id' => $data['id'],
                'qr_code' => $data['point_of_interaction']['transaction_data']['qr_code_base64'],
                'pix_code' => $data['point_of_interaction']['transaction_data']['qr_code']
            ];

        }catch(MPApiException $e) {
            echo "Status do PIX: " . $e->getApiResponse()->getStatusCode() . "\n";
            echo "Content: ";
            var_dump($e->getApiResponse()->getContent());
            echo "\n";
        }catch(\Exception $e) {
            echo $e->getMessage();
        }
    }

}