# CreateContactRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**email** | **string** | Unique email address within the project. |
**first_name** | **string** | Given name. | [optional]
**last_name** | **string** | Family name. | [optional]
**status** | **string** | Initial contact lifecycle status. | [optional]
**subscribed** | **bool** | Initial marketing subscription state. | [optional] [default to true]
**source** | **string** | Acquisition source. | [optional] [default to 'api']
**metadata** | **object** | Caller-defined metadata object. | [optional]
**list_ids** | **string[]** | List UUIDs to assign. | [optional]
**tag_ids** | **string[]** | Existing tag UUIDs to assign. | [optional]
**tag_names** | **string[]** | Tag names to resolve or create. | [optional]
**custom_fields** | **object** | Custom values keyed by field slug. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
