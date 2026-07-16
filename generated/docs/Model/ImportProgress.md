# ImportProgress

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**uuid** | **string** | Import UUID. @format uuid |
**status** | **string** | Current status. @var &#39;draft&#39;|&#39;pending&#39;|&#39;queued&#39;|&#39;processing&#39;|&#39;completed&#39;|&#39;failed&#39; |
**status_label** | **string** | Human-readable status label. |
**progress** | **int** | Completion percentage. @example 65 |
**rows_total** | **int** |  |
**rows_processed** | **int** |  |
**rows_remaining** | **int** |  |
**rows_imported** | **int** |  |
**rows_updated** | **int** |  |
**rows_failed** | **int** |  |
**rows_skipped** | **int** |  |
**current_batch** | **int** |  |
**total_batches** | **int** |  |
**eta_seconds** | **int** | Estimated seconds remaining. |
**speed_per_minute** | **int** | Processing speed in rows per minute. |
**summary** | **string** |  |
**original_filename** | **string** |  |
**started_at** | **\DateTime** |  |
**completed_at** | **\DateTime** |  |
**has_failures** | **bool** |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
