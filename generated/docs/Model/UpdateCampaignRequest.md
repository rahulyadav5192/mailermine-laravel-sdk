# UpdateCampaignRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Campaign name. | [optional]
**subject** | **string** | Rendered email subject. | [optional]
**preview_text** | **string** | Inbox preview text. | [optional]
**from_name** | **string** | Sender display name. | [optional]
**from_email** | **string** | Verified sender address. | [optional]
**reply_to** | **string** | Optional reply address. | [optional]
**template_uuid** | **string** | Published template UUID; empty string clears it. | [optional]
**segment_uuid** | **string** | Audience segment UUID; empty string clears it. | [optional]
**send_immediately** | **bool** | Whether delivery should be immediate. | [optional]
**scheduled_at** | **\DateTime** | Scheduled date/time interpreted in &#x60;timezone&#x60;. ISO-8601 with offset. | [optional]
**timezone** | **string** | IANA delivery timezone. | [optional]
**builder_step** | **int** | Last completed builder step (1-6). | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
