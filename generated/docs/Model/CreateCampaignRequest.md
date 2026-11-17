# CreateCampaignRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Campaign display name. |
**subject** | **string** |  | [optional]
**preview_text** | **string** |  | [optional]
**from_name** | **string** |  | [optional]
**from_email** | **string** |  | [optional]
**reply_to** | **string** |  | [optional]
**template_uuid** | **string** | Published template UUID. | [optional]
**template_id** | **string** | Published template UUID (alias of &#x60;template_uuid&#x60;). | [optional]
**segment_uuid** | **string** | Audience segment UUID. | [optional]
**segment_id** | **string** | Audience segment UUID (alias of &#x60;segment_uuid&#x60;). | [optional]
**send_immediately** | **bool** | Whether delivery should be immediate. Defaults to true (draft). | [optional]
**scheduled_at** | **\DateTime** | Required when &#x60;send_immediately&#x60; is false. ISO-8601 date-time. | [optional]
**timezone** | **string** | IANA timezone used to interpret &#x60;scheduled_at&#x60;. Required when scheduling. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
