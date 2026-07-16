# CampaignEvent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**uuid** | **string** | Event UUID. @format uuid |
**event_type** | **string** | Delivery or engagement event type. @example clicked |
**event_label** | **string** |  |
**source** | **string** | Event ingestion source. |
**payload** | **mixed[]** | Provider/event metadata. @var array&lt;string, mixed&gt;|null |
**occurred_at** | **string** | Provider occurrence time. @format date-time |
**created_at** | **string** | Event persistence time. @format date-time |
**message_uuid** | **string** | Related message UUID when loaded. @format uuid |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
