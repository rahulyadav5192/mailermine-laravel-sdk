# SegmentResource

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public segment UUID. @format uuid |
**name** | **string** | Project-unique segment name. @example Active customers |
**description** | **string** | Optional segment description. |
**rules** | **mixed[]** | Normalized dynamic membership rules. @var array&lt;string, mixed&gt; |
**contact_count** | **int** | Last evaluated matching contact count. @example 342 |
**created_at** | **string** | Creation time. @format date-time |
**updated_at** | **string** | Last update time. @format date-time |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
