# CampaignRecipient

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**status** | [**\OpenAPI\Client\Model\CampaignRecipientStatus**](CampaignRecipientStatus.md) |  |
**status_label** | **string** | Human-readable recipient status. |
**queued_at** | **\DateTime** |  |
**sent_at** | **\DateTime** |  |
**delivered_at** | **\DateTime** |  |
**failed_at** | **\DateTime** |  |
**failure_reason** | **string** | Failure detail, present for failed recipients. |
**contact** | **mixed[]** | Contact snapshot. @var array{uuid: string, email: string, full_name: string}|null |
**message** | **mixed[]** | Generated transactional message. @var array{uuid: string, status: string, status_label: string, error_message: string|null}|null |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
