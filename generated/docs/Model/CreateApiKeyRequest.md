# CreateApiKeyRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Human-readable key name. |
**expires_at** | **\DateTime** | Future expiration time; omit for no expiry. | [optional]
**scopes** | **string[]** | Granted API scopes; null means full legacy access. | [optional]
**permissions** | **string[]** | Backward-compatible alias of scopes. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
