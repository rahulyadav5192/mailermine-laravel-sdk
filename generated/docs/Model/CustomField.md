# CustomField

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public custom field UUID. @format uuid |
**name** | **string** | Human-readable field name. @example Company |
**slug** | **string** | Stable value key used in contact payloads. @example company |
**type** | **string** | Field value type. @var &#39;text&#39;|&#39;textarea&#39;|&#39;number&#39;|&#39;boolean&#39;|&#39;date&#39;|&#39;datetime&#39;|&#39;select&#39;|&#39;multi_select&#39;|&#39;email&#39;|&#39;url&#39;|&#39;phone&#39;|&#39;json&#39; @example text |
**description** | **string** | Optional field description. @example Contact employer |
**required** | **bool** | Whether imports and writes require a value. @example false |
**default_value** | **object** | Default value applied when appropriate. |
**options** | **mixed[]** | Allowed choices for select fields. @var list&lt;mixed&gt;|null |
**created_at** | **string** | Creation time. @format date-time |
**updated_at** | **string** | Last update time. @format date-time |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
