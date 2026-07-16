# ImportJob

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public import UUID. @format uuid |
**status** | **string** | Import lifecycle status. @var &#39;draft&#39;|&#39;pending&#39;|&#39;queued&#39;|&#39;processing&#39;|&#39;completed&#39;|&#39;failed&#39; @example processing |
**progress** | **int** | Completion percentage from 0 through 100. @example 65 |
**original_filename** | **string** | Uploaded source filename. @example contacts.xlsx |
**summary** | **string** | Human-readable completion or failure summary. |
**metadata** | **mixed[]** | Parser suggestions, parse details, and saved configuration. @var array&lt;string, mixed&gt; |
**counters** | **mixed[]** | Row and batch counters. @var array{rows_total: int, rows_imported: int, rows_updated: int, rows_failed: int, rows_skipped: int, current_batch: int, total_batches: int} |
**has_failures** | **bool** | Whether a downloadable failure CSV exists. @example false |
**started_at** | **string** | Processing start time. @format date-time |
**completed_at** | **string** | Processing completion time. @format date-time |
**created_at** | **string** | Job creation time. @format date-time |
**updated_at** | **string** | Last job update time. @format date-time |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
