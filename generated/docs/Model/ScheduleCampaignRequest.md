# ScheduleCampaignRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**send_immediately** | **bool** | Mark ready for immediate sending instead of scheduling. |
**scheduled_at** | **\DateTime** | Required when &#x60;send_immediately&#x60; is false. ISO-8601 date-time interpreted in &#x60;timezone&#x60;. | [optional]
**timezone** | **string** | IANA timezone used to interpret &#x60;scheduled_at&#x60;. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
