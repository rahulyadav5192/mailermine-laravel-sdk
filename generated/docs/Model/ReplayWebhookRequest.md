# ReplayWebhookRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**failed_only** | **bool** | Replay only failed deliveries in the range. | [optional]
**from** | **\DateTime** | Replay deliveries created on or after this ISO-8601 date. | [optional]
**to** | **\DateTime** | Replay deliveries created on or before this ISO-8601 date. | [optional]
**event_types** | **string[]** | Restrict replay to these event types. | [optional]
**delivery_ids** | **string[]** | Replay these specific delivery UUIDs. Overrides range filters. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
