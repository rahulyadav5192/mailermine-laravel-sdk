# UpdateTemplateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Updated project-unique name. | [optional]
**description** | **string** | Updated description; null clears it. | [optional]
**subject** | **string** | Updated subject. | [optional]
**html** | **string** | Updated HTML body. | [optional]
**html_content** | **string** | Backward-compatible alias of html. | [optional]
**text** | **string** | Updated plain-text body. | [optional]
**text_content** | **string** | Backward-compatible alias of text. | [optional]
**status** | [**\OpenAPI\Client\Model\TemplateStatus**](TemplateStatus.md) | Publication status. | [optional]
**editor_type** | **string** | Editor/layout identifier. | [optional]
**category** | **string** | Template category. | [optional]
**tags** | **string[]** | Replacement labels. | [optional]
**variables** | [**\OpenAPI\Client\Model\CreateTemplateRequestVariablesInner[]**](CreateTemplateRequestVariablesInner.md) | Replacement variable definitions. | [optional]
**branding** | [**\OpenAPI\Client\Model\CreateTemplateRequestBranding**](CreateTemplateRequestBranding.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
