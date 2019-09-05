# Merchant's Api Client
Simple desigion to make all merchant's request to the Enfins API.
---
Link to the official documentation: https://app.swaggerhub.com/apis-docs/enfins.com/merchant_en/v1
---
The library currently provides the following operations according to the enfins official doccumentation:
 - /create_bill
 - /find/by_bill_id
 - /find/by_m_order
 - /payout
 - /payout_card
 - /payout_crypto
 - /balance
 - /rates
 - /stats
 - /history
 
## Requirements

PHP 5.5 and later

---

# Usage

Before you can create a new Api client class instance you have to prepare and save your unique merchant ident and secret key in your merchant account settings.
Link for register like a partner - https://enfins.com/ru/partner/registration. Then create your merchant there.

And download api client library

```
composer require enfins/api_client 
```
Create Api client and add your ident and secret key there.

```
$secret_key = 'SECRET_KEY';
$ident = 'IDENT';
$api = new ApiClient($ident,$secret_key,'https://api.enfins.com/v1');
```

Via ApiClient object you can send requests to the Enfins Api.

```
try {
    $createBillResponse = $api->createBill("UAH",200,"UNIQUE_MERCHANT_ORDER","create example bill",["testing"=>true]);

} catch (ApiException $e) {

} catch (Exception $e) {

}
```


