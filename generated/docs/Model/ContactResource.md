# ContactResource

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public contact UUID. @format uuid @example 550e8400-e29b-41d4-a716-446655440000 |
**email** | **string** | Normalized email address. @format email @example ada@example.com |
**first_name** | **string** | Given name. @example Ada |
**last_name** | **string** | Family name. @example Lovelace |
**status** | **string** | Contact lifecycle status. @var &#39;active&#39;|&#39;unsubscribed&#39;|&#39;suppressed&#39;|&#39;bounced&#39;|&#39;complained&#39;|&#39;archived&#39; @example active |
**subscribed** | **bool** | Whether the contact is subscribed to marketing email. @example true |
**source** | **string** | Acquisition source. @example api |
**metadata** | **mixed[]** | Caller-defined metadata. @var array&lt;string, mixed&gt; |
**tags** | **mixed[]** | Loaded tag relationships. @var list&lt;array{id: string, name: string, color: string}&gt; |
**lists** | **mixed[]** | Loaded list relationships. @var list&lt;array{id: string, name: string}&gt; |
**custom_fields** | **mixed[]** | Custom field values keyed by field slug. @var array&lt;string, mixed&gt; |
**created_at** | **string** | Creation time (ISO-8601). @format date-time @example 2026-07-16T10:00:00.000000Z |
**updated_at** | **string** | Last update time (ISO-8601). @format date-time @example 2026-07-16T11:00:00.000000Z |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
