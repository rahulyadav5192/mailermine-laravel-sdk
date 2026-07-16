# DomainResource

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public domain UUID. @format uuid |
**domain** | **string** | Sending domain. @example mail.example.com |
**status** | **string** | Provisioning status. @example pending |
**verified** | **bool** | Whether ownership is verified. @example false |
**verification_status** | **string** | Verification status. @var &#39;provisioning&#39;|&#39;pending&#39;|&#39;verified&#39;|&#39;failed&#39; |
**provider** | **string** | Delivery provider label. @example Amazon SES |
**created_at** | **string** | Creation time. @format date-time |
**verified_at** | **string** | Verification completion time. @format date-time |
**last_checked_at** | **string** | Last verification check. @format date-time |
**dns_status** | **string** | Aggregate DNS status. |
**dkim_status** | **string** | DKIM verification status. |
**spf_status** | **string** | SPF verification status. |
**tracking_status** | **string** | Tracking-domain status. @example not_configured |
**mail_from** | **string** | MAIL FROM domain; present on detailed responses. |
**verification_error** | **string** | Last provider verification error. |
**verification_token** | **string** | Provider verification token. |
**dmarc_recommendation** | **mixed[]** | Recommended DMARC record. @var array{type: string, name: string, value: string, note: string}|null |
**dns_records** | [**\OpenAPI\Client\Model\DNSRecord[]**](DNSRecord.md) | DNS records required for verification. |
**dns_summary** | **mixed[]** | Aggregate status by purpose. @var array{verification: string, spf: string, dkim: string}|null |
**project** | **mixed[]** | Parent project summary. @var array{id: string, name: string}|null |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
