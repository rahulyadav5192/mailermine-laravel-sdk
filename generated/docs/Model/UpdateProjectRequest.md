# UpdateProjectRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Updated project name. | [optional]
**slug** | **string** | Updated lowercase kebab-case slug. | [optional]
**description** | **string** | Updated description; null clears it. | [optional]
**environment** | **string** | Runtime environment. | [optional]
**timezone** | **string** | IANA timezone. | [optional]
**default_sender** | **string** | Default sender; null clears it. | [optional]
**settings** | [**\OpenAPI\Client\Model\CreateProjectRequestSettings**](CreateProjectRequestSettings.md) |  | [optional]
**status** | **string** | Archive or restore the project. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
