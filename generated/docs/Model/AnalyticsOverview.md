# AnalyticsOverview

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**emails_sent** | **int** | Total emails sent in the selected range. |
**campaigns** | **int** | Number of campaigns that sent in the selected range. |
**delivery_rate** | **float** | Delivered / sent as a percentage. |
**open_rate** | **float** | Unique opens / delivered emails that had open tracking, as a percentage. |
**click_rate** | **float** | Unique clicks / delivered emails that had click tracking, as a percentage. |
**bounce_rate** | **float** | Bounced / sent as a percentage. |
**complaint_rate** | **float** | Complaints / sent as a percentage. |
**daily_series** | [**\OpenAPI\Client\Model\AnalyticsOverviewDailySeriesInner[]**](AnalyticsOverviewDailySeriesInner.md) | Daily performance series. |
**top_campaigns** | [**\OpenAPI\Client\Model\AnalyticsOverviewTopCampaignsInner[]**](AnalyticsOverviewTopCampaignsInner.md) | Top campaigns by volume. |
**top_links** | [**\OpenAPI\Client\Model\AnalyticsOverviewTopLinksInner[]**](AnalyticsOverviewTopLinksInner.md) | Top tracked links by clicks. |
**recent_activity** | [**\OpenAPI\Client\Model\AnalyticsOverviewRecentActivityInner[]**](AnalyticsOverviewRecentActivityInner.md) | Recent recipient activity. |
**tracking** | [**\OpenAPI\Client\Model\AnalyticsOverviewTracking**](AnalyticsOverviewTracking.md) |  | [optional]
**tracking_domains** | [**\OpenAPI\Client\Model\AnalyticsEngagementByTrackingDomainInner[]**](AnalyticsEngagementByTrackingDomainInner.md) | Volume, engagement and health per custom tracking domain. The row with &#x60;hostname: null&#x60; is the shared host. Empty when no tracking domain is configured. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
