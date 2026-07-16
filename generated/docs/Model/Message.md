# Message

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**uuid** | **string** | Public message UUID. |
**from_email** | **string** |  |
**from_name** | **string** |  |
**to_email** | **string** | Primary recipient email. |
**to_emails** | **mixed[]** | All &#x60;to&#x60; recipients. |
**cc** | **mixed[]** | Carbon copy recipients. |
**bcc** | **mixed[]** | Blind carbon copy recipients. |
**reply_to** | **string** |  |
**headers** | **mixed[]** | Custom headers applied to the message. |
**subject** | **string** |  |
**status** | [**\OpenAPI\Client\Model\MessageStatus**](MessageStatus.md) | Delivery status. |
**status_label** | **string** |  |
**provider** | **string** |  |
**provider_label** | **string** |  |
**provider_message_id** | **string** |  |
**error_message** | **string** |  |
**metadata** | **mixed[]** | Arbitrary key-value metadata stored with the message. |
**tags** | **mixed[]** | Tags for filtering and analytics. |
**attachments** | [**\OpenAPI\Client\Model\EmailAttachment[]**](EmailAttachment.md) |  |
**scheduled_at** | **string** |  |
**sent_at** | **string** |  |
**created_at** | **string** |  |
**updated_at** | **string** |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
