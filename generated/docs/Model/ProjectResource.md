# ProjectResource

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public project UUID. @example 550e8400-e29b-41d4-a716-446655440000 |
**name** | **string** | Display name. @example Production Mail |
**slug** | **string** | Workspace-unique slug. @example production-mail |
**description** | **string** | Optional project description. @example Customer-facing transactional email |
**environment** | **string** | Runtime environment. @var &#39;production&#39;|&#39;staging&#39;|&#39;development&#39;|&#39;test&#39; @example production |
**timezone** | **string** | IANA timezone. @example UTC |
**default_sender** | **string** | Default sender address hint. @example hello@example.com |
**status** | **string** | Project lifecycle status. @var &#39;active&#39;|&#39;archived&#39; @example active |
**settings** | **mixed[]** | Extensible project settings. @var array&lt;string, mixed&gt; |
**email_count** | **int** | Number of messages in the project. @example 1240 |
**domain_count** | **int** | Number of sending domains. @example 2 |
**api_key_count** | **int** | Number of API keys. @example 3 |
**created_at** | **string** | Creation time (ISO-8601). @format date-time @example 2026-07-16T10:00:00.000000Z |
**updated_at** | **string** | Last update time (ISO-8601). @format date-time @example 2026-07-16T11:00:00.000000Z |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
