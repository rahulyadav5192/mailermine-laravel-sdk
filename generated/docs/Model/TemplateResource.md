# TemplateResource

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public template UUID. @format uuid |
**name** | **string** | Template name. @example Welcome Email |
**slug** | **string** | Project-unique slug. @example welcome-email |
**description** | **string** | Optional description. |
**subject** | **string** | Renderable subject. @example Welcome {{first_name}} |
**status** | **string** | Publication status. @var &#39;draft&#39;|&#39;published&#39;|&#39;archived&#39; @example published |
**editor_type** | **string** | Editor/layout type. @example html |
**category** | **string** | Optional template category. @example onboarding |
**tags** | **mixed[]** | Searchable labels. @var list&lt;string&gt; |
**created_at** | **string** | Creation time. @format date-time |
**updated_at** | **string** | Last update time. @format date-time |
**html** | **string** | HTML body; present on detailed responses. |
**text** | **string** | Plain-text body; present on detailed responses. |
**html_content** | **string** | Backward-compatible alias of html. |
**text_content** | **string** | Backward-compatible alias of text. |
**branding** | **mixed[]** | Branding and layout configuration. @var array&lt;string, mixed&gt;|null |
**metadata** | **mixed[]** | Derived category, type, preview text, and tags. @var array&lt;string, mixed&gt;|null |
**variables** | [**\OpenAPI\Client\Model\TemplateVariable[]**](TemplateVariable.md) | Variable definitions. |
**project** | **mixed[]** | Parent project summary. @var array{id: string, name: string}|null |
**usage** | **mixed[]** | Campaign usage counters. @var array{campaigns: int, scheduled_campaigns: int}|null |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
