# ApiKeyResource

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public key UUID. @format uuid @example 550e8400-e29b-41d4-a716-446655440000 |
**name** | **string** | Human-readable key name. @example CI Production |
**prefix** | **string** | Safe display prefix. @example mm_live_abcd... |
**masked_key** | **string** | Alias of prefix. @example mm_live_abcd... |
**status** | **string** | Key lifecycle status. @var &#39;active&#39;|&#39;disabled&#39;|&#39;revoked&#39;|&#39;expired&#39; @example active |
**scopes** | **mixed[]** | Granted scopes; null means full legacy access. @var list&lt;string&gt;|null |
**permissions** | **mixed[]** | Backward-compatible alias of scopes. @var list&lt;string&gt;|null |
**environment** | **string** | Parent project environment. @example production |
**last_used_at** | **string** | Last successful authentication time. @format date-time |
**expires_at** | **string** | Expiration time; null means no expiry. @format date-time |
**created_at** | **string** | Creation time. @format date-time |
**updated_at** | **string** | Last update time. @format date-time |
**secret** | **string** | One-time plaintext secret, returned only on create/rotate. @example mm_live_secret |
**key** | **string** | Backward-compatible alias of secret, returned only on create/rotate. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
