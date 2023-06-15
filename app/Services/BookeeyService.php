<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

// use Illuminate\Http\Request;

class BookeeyService
{
    private $payment_url;
    private $status_url;
    private $requestData;
    private $secret;
    private $merch_uid;
    private $sub_merch_uid;
    private $headers;
    private $request_client;

    public function __construct(Client $request_client)
    {
        $this->request_client = $request_client;
        $this->payment_url = env("BOOKEEY_PAYMENT_URL");
        $this->status_url = env("BOOKEEY_STATUS_URL");

        $this->secret = env("BOOKEEY_SECRET_KEY");
        $this->merch_uid = env('BOOKEEY_MERCH_UID');
        $this->sub_merch_uid = env("BOOKEEY_SUB_MERCH_UID");

        $this->headers = [
            'Content-Type' => "application/json",
            'hashMac' => "8B95BEED1BDAAA0B0672D28BFA7F0C08408EFD7AAACA6C78582242A1348ABAB0542C0CD43BC9AD9DD906B001C1B220557011D8E0770DDFB45CE70C8D7D069C7F"
        ];
    }

    private function buildRequest($url, $json)
    {
        $request = new Request("POST", $url, $this->headers);

        $response = $this->request_client->send($request, compact('json'));

        if ($response->getStatusCode() != 200) {
            return false;
        }

        return json_decode($response->getBody(), true);
    }

    public function sendPayment()
    {
        return $this->buildRequest($this->payment_url, $this->requestData);
    }

    public function getStatus($merchantTxnId)
    {
        return $this->buildRequest($this->status_url, [
            "Mid" => $this->merch_uid,
            "MerchantTxnRefNo" => [$merchantTxnId],
            "HashMac" => "8B95BEED1BDAAA0B0672D28BFA7F0C08408EFD7AAACA6C78582242A1348ABAB0542C0CD43BC9AD9DD906B001C1B220557011D8E0770DDFB45CE70C8D7D069C7F"
        ]);
    }

    public function loadRequest($data)
    {
        $this->requestData =  [
            "DBRqst" => "PY_ECom",
            "Do_Appinfo" => [
                "APIVer" => "1.6",
                "APPTyp" => "WEB",
                "AppVer" => "1"
            ],
            "Do_MerchDtl" => [
                "BKY_PRDENUM" => "ECom",
                "FURL" => $data['fail_url'], // error redirect
                "MerchUID" => $this->merch_uid,
                "SURL" => $data['success_url'], // success redirect
                // 'setSecretKey' => $this->secret,
            ],
            "Do_PyrDtl" => [
                "Pyr_MPhone" => "597344722",// EHJEZ 
                "Pyr_Name" => "Ahmed",// EHJEZ
                "ISDNCD" => "970"
            ],
            "Do_TxnDtl" => [
                [
                    "SubMerchUID" => $this->sub_merch_uid,
                    "Txn_AMT" => $data['payment'] // PAYMENT
                ]
            ],
            "Do_TxnHdr" => [
                'Merch_Txn_UID' => rand(100000000000, 999999999999),
                "PayFor" => "ECom",
                "PayMethod" => $data['payment_method'],
                "Txn_HDR" => "2987228884280325",
                "hashMac" => "8B95BEED1BDAAA0B0672D28BFA7F0C08408EFD7AAACA6C78582242A1348ABAB0542C0CD43BC9AD9DD906B001C1B220557011D8E0770DDFB45CE70C8D7D069C7F",
                "emailAddress" => $data['email'], // CUSTOMER
                "phoneAddress" => $data['phone'],// CUSTOMER
                "address" => "kuwait",
                "ISDNCode" => "123",
                "merchantIBanNo" => "1234123412341234",
                "accountTitleName" => "test",
                "swiftCode" => "ABC",
                "merchantName" => "000it",
            ]
        ];
        return $this;
    }
}
