# ExportJob

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public export UUID. @format uuid |
**status** | **string** | Export lifecycle status. @var &#39;pending&#39;|&#39;processing&#39;|&#39;completed&#39;|&#39;failed&#39; @example pending |
**contact_count** | **int** | Number of contacts written to the export. @example 1250 |
**filters** | **mixed[]** | Filters captured when the export was queued. @var array&lt;string, mixed&gt; |
**download_url** | **string** | Download URL, available only after completion. @format uri |
**completed_at** | **string** | Processing completion time. @format date-time |
**created_at** | **string** | Job creation time. @format date-time |
**updated_at** | **string** | Last job update time. @format date-time |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
