# CampaignResource

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**uuid** | **string** | Public campaign UUID. @format uuid |
**name** | **string** | Campaign display name. @example August product newsletter |
**subject** | **string** | Email subject after campaign configuration. @example What is new in August |
**preview_text** | **string** | Inbox preview text. |
**from_name** | **string** | Sender display name. @example MailerMine |
**from_email** | **string** | Verified sender email. @format email |
**reply_to** | **string** | Optional reply address. @format email |
**status** | [**\OpenAPI\Client\Model\CampaignStatus**](CampaignStatus.md) | Current lifecycle status. |
**status_label** | **string** | Human-readable lifecycle status. @example Scheduled |
**send_immediately** | **bool** | Whether delivery is configured as immediate. |
**scheduled_at** | **string** | Scheduled delivery time. @format date-time |
**timezone** | **string** | IANA delivery timezone. @example America/New_York |
**sent_at** | **string** | Actual send time. @format date-time |
**estimated_recipients** | **int** |  |
**total_recipients** | **int** |  |
**queued_count** | **int** |  |
**sending_count** | **int** |  |
**sent_count** | **int** |  |
**failed_count** | **int** |  |
**completed_count** | **int** |  |
**completion_percentage** | **float** | Completion percentage from 0 through 100. @example 72.5 |
**started_at** | **string** | Processing start time. @format date-time |
**completed_at** | **string** | Processing completion time. @format date-time |
**last_processed_at** | **string** | Last recipient processing time. @format date-time |
**builder_step** | **int** | Last completed campaign-builder step (1-6). |
**created_at** | **string** | Creation time. @format date-time |
**updated_at** | **string** | Last update time. @format date-time |
**project** | **mixed[]** | Owning project relationship. @var array{uuid: string, name: string}|null |
**template** | **mixed[]** | Selected template relationship. @var array{uuid: string, name: string, subject: string|null}|null |
**segment** | **mixed[]** | Selected audience segment relationship. @var array{uuid: string, name: string, contact_count: int}|null |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
