# SendEmailRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**from** | **string** | Sender address. Format: &#x60;Name &lt;email@domain.com&gt;&#x60; or &#x60;email@domain.com&#x60;. |
**to** | **string[]** | Recipient email address(es). A single string is accepted for backward compatibility. |
**cc** | **string[]** | Carbon copy recipients. | [optional]
**bcc** | **string[]** | Blind carbon copy recipients. | [optional]
**template_id** | **string** | Template UUID to render instead of inline content. | [optional]
**variables** | **object** | Template variables (key-value object). | [optional]
**subject** | **string** | Email subject. Required when not using a template. | [optional]
**html** | **string** | HTML body. Required with &#x60;text&#x60; when not using a template. | [optional]
**text** | **string** | Plain text body. Required with &#x60;html&#x60; when not using a template. | [optional]
**reply_to** | **string** | Reply-to address. | [optional]
**metadata** | **object** | Custom metadata stored with the message. | [optional]
**tags** | **string[]** | Tags for filtering and analytics. | [optional]
**headers** | **object** | Custom email headers (requires &#x60;allow_custom_headers&#x60; plan capability). | [optional]
**attachments** | [**\OpenAPI\Client\Model\SendEmailRequestAttachmentsInner[]**](SendEmailRequestAttachmentsInner.md) | Base64-encoded file attachments. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
