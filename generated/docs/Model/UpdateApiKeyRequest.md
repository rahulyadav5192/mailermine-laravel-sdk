# UpdateApiKeyRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Updated key name. | [optional]
**expires_at** | **\DateTime** | Future expiration time; null clears expiry. | [optional]
**status** | **string** | Key lifecycle status. | [optional]
**scopes** | **string[]** | Replacement scope list; null restores full legacy access. | [optional]
**permissions** | **string[]** | Backward-compatible alias of scopes. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
