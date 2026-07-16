# DNSRecord

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**record_type** | **string** | DNS record type. @var &#39;TXT&#39;|&#39;CNAME&#39;|&#39;MX&#39; @example CNAME |
**record_name** | **string** | DNS host/name. @example selector1._domainkey.mail.example.com |
**record_value** | **string** | DNS record value. @example selector1.dkim.provider.example |
**name** | **string** | Alias of record_name. |
**value** | **string** | Alias of record_value. |
**purpose** | **string** | Record purpose. @var &#39;verification&#39;|&#39;spf&#39;|&#39;dkim&#39;|&#39;mail_from&#39;|&#39;dmarc&#39; @example dkim |
**priority** | **int** | Optional provider priority, primarily for MX records. @example 10 |
**ttl** | **int** | DNS TTL in seconds. @example 300 |
**status** | **string** | Verification state. @var &#39;pending&#39;|&#39;verified&#39;|&#39;failed&#39; @example pending |
**purpose_label** | **string** | Human-readable purpose. @example DKIM |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
