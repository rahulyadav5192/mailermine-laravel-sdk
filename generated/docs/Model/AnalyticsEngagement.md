# AnalyticsEngagement

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**from** | **string** | Range start (ISO-8601). |
**to** | **string** | Range end (ISO-8601). |
**opens** | **int** | Total opens. |
**unique_opens** | **int** | Unique opens. |
**clicks** | **int** | Total clicks. |
**unique_clicks** | **int** | Unique clicks. |
**open_rate** | **float** | Unique opens / delivered emails that had open tracking, as a percentage. |
**ctr** | **float** | Click-through rate: unique clicks / delivered emails that had click tracking, as a percentage. |
**ctor** | **float** | Click-to-open rate: clicks / opens as a percentage. |
**sent** | **int** | Total sent. |
**delivered** | **int** | Total delivered. |
**opens_tracked_delivered** | **int** | Delivered emails that had open tracking (the open-rate denominator). | [optional]
**clicks_tracked_delivered** | **int** | Delivered emails that had click tracking (the CTR denominator). | [optional]
**by_tracking_domain** | [**\OpenAPI\Client\Model\AnalyticsEngagementByTrackingDomainInner[]**](AnalyticsEngagementByTrackingDomainInner.md) | Volume and engagement per custom tracking domain. The row with &#x60;hostname: null&#x60; is the shared host. Empty when no tracking domain is configured. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
