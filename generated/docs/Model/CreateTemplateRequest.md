# CreateTemplateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Project-unique template name. |
**description** | **string** | Optional internal description. | [optional]
**subject** | **string** | Subject with optional &#x60;{{variable}}&#x60; placeholders. |
**html** | **string** | HTML body; required when no other body field is provided. | [optional]
**html_content** | **string** | Backward-compatible alias of html. | [optional]
**text** | **string** | Plain-text body. | [optional]
**text_content** | **string** | Backward-compatible alias of text. | [optional]
**status** | [**\OpenAPI\Client\Model\TemplateStatus**](TemplateStatus.md) | Initial publication status. | [optional]
**editor_type** | **string** | Editor/layout identifier. | [optional]
**category** | **string** | Template category. | [optional]
**tags** | **string[]** | Searchable labels. | [optional]
**variables** | [**\OpenAPI\Client\Model\CreateTemplateRequestVariablesInner[]**](CreateTemplateRequestVariablesInner.md) | Template variable definitions. | [optional]
**branding** | [**\OpenAPI\Client\Model\CreateTemplateRequestBranding**](CreateTemplateRequestBranding.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
