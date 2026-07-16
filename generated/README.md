# OpenAPIClient-php

MailerMine API — send email and manage projects, API keys, domains, templates, contacts, audiences, and delivery data.


## Installation & Usage

### Requirements

PHP 8.1 and later.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$create_api_key_request = new \OpenAPI\Client\Model\CreateApiKeyRequest(); // \OpenAPI\Client\Model\CreateApiKeyRequest

try {
    $result = $apiInstance->createApiKey($project, $create_api_key_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->createApiKey: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *http://127.0.0.1:8000/api/v1*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*APIKeysApi* | [**createApiKey**](docs/Api/APIKeysApi.md#createapikey) | **POST** /projects/{project}/api-keys | Create API key
*APIKeysApi* | [**deleteApiKey**](docs/Api/APIKeysApi.md#deleteapikey) | **DELETE** /projects/{project}/api-keys/{apiKey} | Delete API key
*APIKeysApi* | [**getApiKey**](docs/Api/APIKeysApi.md#getapikey) | **GET** /projects/{project}/api-keys/{apiKey} | Get API key
*APIKeysApi* | [**listApiKeys**](docs/Api/APIKeysApi.md#listapikeys) | **GET** /projects/{project}/api-keys | List API keys
*APIKeysApi* | [**revealApiKey**](docs/Api/APIKeysApi.md#revealapikey) | **POST** /projects/{project}/api-keys/{apiKey}/reveal | Reveal API key
*APIKeysApi* | [**rotateApiKey**](docs/Api/APIKeysApi.md#rotateapikey) | **POST** /projects/{project}/api-keys/{apiKey}/rotate | Rotate API key
*APIKeysApi* | [**updateApiKey**](docs/Api/APIKeysApi.md#updateapikey) | **PATCH** /projects/{project}/api-keys/{apiKey} | Update API key
*AnalyticsApi* | [**analyticsCampaigns**](docs/Api/AnalyticsApi.md#analyticscampaigns) | **GET** /analytics/campaigns | Campaign analytics breakdown
*AnalyticsApi* | [**analyticsDomains**](docs/Api/AnalyticsApi.md#analyticsdomains) | **GET** /analytics/domains | Domain analytics
*AnalyticsApi* | [**analyticsEngagement**](docs/Api/AnalyticsApi.md#analyticsengagement) | **GET** /analytics/engagement | Engagement analytics
*AnalyticsApi* | [**analyticsMessages**](docs/Api/AnalyticsApi.md#analyticsmessages) | **GET** /analytics/messages | Message analytics
*AnalyticsApi* | [**analyticsOverview**](docs/Api/AnalyticsApi.md#analyticsoverview) | **GET** /analytics/overview | Analytics overview
*AnalyticsApi* | [**analyticsProjects**](docs/Api/AnalyticsApi.md#analyticsprojects) | **GET** /analytics/projects | Project analytics
*AnalyticsApi* | [**analyticsProviders**](docs/Api/AnalyticsApi.md#analyticsproviders) | **GET** /analytics/providers | Provider analytics
*AudiencesApi* | [**addAudienceMembers**](docs/Api/AudiencesApi.md#addaudiencemembers) | **POST** /audiences/{source}/{audience}/contacts | Add audience members
*AudiencesApi* | [**getAudience**](docs/Api/AudiencesApi.md#getaudience) | **GET** /audiences/{source}/{audience} | Get audience
*AudiencesApi* | [**listAudiences**](docs/Api/AudiencesApi.md#listaudiences) | **GET** /audiences | List audiences
*AudiencesApi* | [**removeAudienceMembers**](docs/Api/AudiencesApi.md#removeaudiencemembers) | **DELETE** /audiences/{source}/{audience}/contacts | Remove audience members
*CampaignAnalyticsApi* | [**campaignAnalytics**](docs/Api/CampaignAnalyticsApi.md#campaignanalytics) | **GET** /campaigns/{campaign}/analytics | Get campaign analytics
*CampaignAnalyticsApi* | [**campaignLinks**](docs/Api/CampaignAnalyticsApi.md#campaignlinks) | **GET** /campaigns/{campaign}/links | Get campaign links
*CampaignEventsApi* | [**campaignActivities**](docs/Api/CampaignEventsApi.md#campaignactivities) | **GET** /campaigns/{campaign}/activities | List campaign activities
*CampaignEventsApi* | [**campaignEvents**](docs/Api/CampaignEventsApi.md#campaignevents) | **GET** /campaigns/{campaign}/events | List campaign events
*CampaignEventsApi* | [**campaignRecipients**](docs/Api/CampaignEventsApi.md#campaignrecipients) | **GET** /campaigns/{campaign}/recipients | List campaign recipients
*CampaignEventsApi* | [**campaignTimeline**](docs/Api/CampaignEventsApi.md#campaigntimeline) | **GET** /campaigns/{campaign}/timeline | Get campaign timeline
*CampaignLifecycleApi* | [**archiveCampaign**](docs/Api/CampaignLifecycleApi.md#archivecampaign) | **POST** /campaigns/{campaign}/archive | Archive campaign
*CampaignLifecycleApi* | [**cancelCampaign**](docs/Api/CampaignLifecycleApi.md#cancelcampaign) | **POST** /campaigns/{campaign}/cancel | Cancel campaign
*CampaignLifecycleApi* | [**duplicateCampaign**](docs/Api/CampaignLifecycleApi.md#duplicatecampaign) | **POST** /campaigns/{campaign}/duplicate | Duplicate campaign
*CampaignLifecycleApi* | [**getCampaignProgress**](docs/Api/CampaignLifecycleApi.md#getcampaignprogress) | **GET** /campaigns/{campaign}/progress | Get campaign progress
*CampaignLifecycleApi* | [**pauseCampaign**](docs/Api/CampaignLifecycleApi.md#pausecampaign) | **POST** /campaigns/{campaign}/pause | Pause campaign
*CampaignLifecycleApi* | [**readyCampaign**](docs/Api/CampaignLifecycleApi.md#readycampaign) | **POST** /campaigns/{campaign}/mark-ready | Mark campaign ready
*CampaignLifecycleApi* | [**restoreCampaign**](docs/Api/CampaignLifecycleApi.md#restorecampaign) | **POST** /campaigns/{campaignUuid}/restore | Restore campaign
*CampaignLifecycleApi* | [**resumeCampaign**](docs/Api/CampaignLifecycleApi.md#resumecampaign) | **POST** /campaigns/{campaign}/resume | Resume campaign
*CampaignLifecycleApi* | [**scheduleCampaign**](docs/Api/CampaignLifecycleApi.md#schedulecampaign) | **POST** /campaigns/{campaign}/schedule | Schedule campaign
*CampaignLifecycleApi* | [**sendCampaign**](docs/Api/CampaignLifecycleApi.md#sendcampaign) | **POST** /campaigns/{campaign}/send | Send campaign
*CampaignsApi* | [**createCampaign**](docs/Api/CampaignsApi.md#createcampaign) | **POST** /campaigns | Create campaign
*CampaignsApi* | [**deleteCampaign**](docs/Api/CampaignsApi.md#deletecampaign) | **DELETE** /campaigns/{campaign} | Delete campaign
*CampaignsApi* | [**getCampaign**](docs/Api/CampaignsApi.md#getcampaign) | **GET** /campaigns/{campaign} | Get campaign
*CampaignsApi* | [**listCampaigns**](docs/Api/CampaignsApi.md#listcampaigns) | **GET** /campaigns | List campaigns
*CampaignsApi* | [**previewCampaign**](docs/Api/CampaignsApi.md#previewcampaign) | **GET** /campaigns/{campaign}/preview | Preview campaign
*CampaignsApi* | [**previewCampaignRecipients**](docs/Api/CampaignsApi.md#previewcampaignrecipients) | **GET** /campaigns/{campaign}/recipient-preview | Preview campaign recipients
*CampaignsApi* | [**updateCampaign**](docs/Api/CampaignsApi.md#updatecampaign) | **PATCH** /campaigns/{campaign} | Update campaign
*CampaignsApi* | [**validateCampaign**](docs/Api/CampaignsApi.md#validatecampaign) | **GET** /campaigns/{campaign}/validate | Validate campaign
*ContactsApi* | [**bulkDeleteContacts**](docs/Api/ContactsApi.md#bulkdeletecontacts) | **POST** /contacts/bulk-delete | Bulk delete contacts
*ContactsApi* | [**bulkRestoreContacts**](docs/Api/ContactsApi.md#bulkrestorecontacts) | **POST** /contacts/restore | Bulk restore contacts
*ContactsApi* | [**bulkUpdateContacts**](docs/Api/ContactsApi.md#bulkupdatecontacts) | **POST** /contacts/bulk-update | Bulk update contacts
*ContactsApi* | [**createContact**](docs/Api/ContactsApi.md#createcontact) | **POST** /contacts | Create contact
*ContactsApi* | [**deleteContact**](docs/Api/ContactsApi.md#deletecontact) | **DELETE** /contacts/{contact} | Delete contact
*ContactsApi* | [**getContact**](docs/Api/ContactsApi.md#getcontact) | **GET** /contacts/{contact} | Get contact
*ContactsApi* | [**listContacts**](docs/Api/ContactsApi.md#listcontacts) | **GET** /contacts | List contacts
*ContactsApi* | [**restoreContact**](docs/Api/ContactsApi.md#restorecontact) | **POST** /contacts/{contact}/restore | Restore contact
*ContactsApi* | [**updateContact**](docs/Api/ContactsApi.md#updatecontact) | **PATCH** /contacts/{contact} | Update contact
*DomainsApi* | [**createDomain**](docs/Api/DomainsApi.md#createdomain) | **POST** /domains | Create domain
*DomainsApi* | [**deleteDomain**](docs/Api/DomainsApi.md#deletedomain) | **DELETE** /domains/{domain} | Delete domain
*DomainsApi* | [**getDomain**](docs/Api/DomainsApi.md#getdomain) | **GET** /domains/{domain} | Get domain
*DomainsApi* | [**listDomains**](docs/Api/DomainsApi.md#listdomains) | **GET** /domains | List domains
*DomainsApi* | [**verifyDomain**](docs/Api/DomainsApi.md#verifydomain) | **POST** /domains/{domain}/verify | Verify domain
*EmailsApi* | [**sendEmail**](docs/Api/EmailsApi.md#sendemail) | **POST** /emails | Send email
*EventsApi* | [**getEvent**](docs/Api/EventsApi.md#getevent) | **GET** /events/{emailEvent} | Get event
*EventsApi* | [**listEvents**](docs/Api/EventsApi.md#listevents) | **GET** /events | List events
*ExportsApi* | [**downloadContactExport**](docs/Api/ExportsApi.md#downloadcontactexport) | **GET** /contacts/exports/{contactExport}/download | Download contact export
*ExportsApi* | [**exportContacts**](docs/Api/ExportsApi.md#exportcontacts) | **POST** /contacts/export | Export contacts
*ExportsApi* | [**getContactExport**](docs/Api/ExportsApi.md#getcontactexport) | **GET** /contacts/exports/{contactExport} | Get contact export
*ImportsApi* | [**configureContactImport**](docs/Api/ImportsApi.md#configurecontactimport) | **POST** /contacts/imports/{contactImport}/config | Configure contact import
*ImportsApi* | [**downloadContactImportFailures**](docs/Api/ImportsApi.md#downloadcontactimportfailures) | **GET** /contacts/imports/{contactImport}/failures | Download import failures
*ImportsApi* | [**getContactImport**](docs/Api/ImportsApi.md#getcontactimport) | **GET** /contacts/imports/{contactImport} | Get contact import
*ImportsApi* | [**importContacts**](docs/Api/ImportsApi.md#importcontacts) | **POST** /contacts/import | Upload contact import
*ImportsApi* | [**listContactImports**](docs/Api/ImportsApi.md#listcontactimports) | **GET** /contacts/imports | List contact imports
*ImportsApi* | [**startContactImport**](docs/Api/ImportsApi.md#startcontactimport) | **POST** /contacts/imports/{contactImport}/start | Start contact import
*ListsApi* | [**addContactsToList**](docs/Api/ListsApi.md#addcontactstolist) | **POST** /lists/{list}/contacts | Add contacts to list
*ListsApi* | [**bulkAddContactsToList**](docs/Api/ListsApi.md#bulkaddcontactstolist) | **POST** /lists/{list}/contacts/bulk-add | Add contacts to list
*ListsApi* | [**bulkRemoveContactsFromList**](docs/Api/ListsApi.md#bulkremovecontactsfromlist) | **POST** /lists/{list}/contacts/bulk-remove | Remove contacts from list
*ListsApi* | [**createList**](docs/Api/ListsApi.md#createlist) | **POST** /lists | Create contact list
*ListsApi* | [**deleteList**](docs/Api/ListsApi.md#deletelist) | **DELETE** /lists/{list} | Delete contact list
*ListsApi* | [**getList**](docs/Api/ListsApi.md#getlist) | **GET** /lists/{list} | Get contact list
*ListsApi* | [**listLists**](docs/Api/ListsApi.md#listlists) | **GET** /lists | List contact lists
*ListsApi* | [**removeContactsFromList**](docs/Api/ListsApi.md#removecontactsfromlist) | **DELETE** /lists/{list}/contacts | Remove contacts from list
*ListsApi* | [**removeContactsFromListLegacy**](docs/Api/ListsApi.md#removecontactsfromlistlegacy) | **POST** /lists/{list}/contacts/remove | Remove contacts from list
*ListsApi* | [**updateList**](docs/Api/ListsApi.md#updatelist) | **PATCH** /lists/{list} | Update contact list
*MarketingApi* | [**createCustomField**](docs/Api/MarketingApi.md#createcustomfield) | **POST** /custom-fields | Create custom field
*MarketingApi* | [**deleteCustomField**](docs/Api/MarketingApi.md#deletecustomfield) | **DELETE** /custom-fields/{customField} | Delete custom field
*MarketingApi* | [**getCustomField**](docs/Api/MarketingApi.md#getcustomfield) | **GET** /custom-fields/{customField} | Get custom field
*MarketingApi* | [**listCustomFields**](docs/Api/MarketingApi.md#listcustomfields) | **GET** /custom-fields | List custom fields
*MarketingApi* | [**updateCustomField**](docs/Api/MarketingApi.md#updatecustomfield) | **PATCH** /custom-fields/{customField} | Update custom field
*MessagesApi* | [**getMessage**](docs/Api/MessagesApi.md#getmessage) | **GET** /delivery-logs/{message} | Get message
*MessagesApi* | [**listMessages**](docs/Api/MessagesApi.md#listmessages) | **GET** /delivery-logs | List messages
*MessagesApi* | [**messageEvents**](docs/Api/MessagesApi.md#messageevents) | **GET** /messages/{message}/events | Message events
*ProjectsApi* | [**createProject**](docs/Api/ProjectsApi.md#createproject) | **POST** /projects | Create project
*ProjectsApi* | [**deleteProject**](docs/Api/ProjectsApi.md#deleteproject) | **DELETE** /projects/{project} | Delete project
*ProjectsApi* | [**getProject**](docs/Api/ProjectsApi.md#getproject) | **GET** /projects/{project} | Get project
*ProjectsApi* | [**listProjects**](docs/Api/ProjectsApi.md#listprojects) | **GET** /projects | List projects
*ProjectsApi* | [**updateProject**](docs/Api/ProjectsApi.md#updateproject) | **PATCH** /projects/{project} | Update project
*SegmentsApi* | [**countSegment**](docs/Api/SegmentsApi.md#countsegment) | **GET** /segments/{segment}/count | Refresh segment count
*SegmentsApi* | [**createSegment**](docs/Api/SegmentsApi.md#createsegment) | **POST** /segments | Create segment
*SegmentsApi* | [**deleteSegment**](docs/Api/SegmentsApi.md#deletesegment) | **DELETE** /segments/{segment} | Delete segment
*SegmentsApi* | [**getSegment**](docs/Api/SegmentsApi.md#getsegment) | **GET** /segments/{segment} | Get segment
*SegmentsApi* | [**listSegments**](docs/Api/SegmentsApi.md#listsegments) | **GET** /segments | List segments
*SegmentsApi* | [**previewSegment**](docs/Api/SegmentsApi.md#previewsegment) | **POST** /segments/{segment}/preview | Preview segment
*SegmentsApi* | [**previewSegmentRules**](docs/Api/SegmentsApi.md#previewsegmentrules) | **POST** /segments/preview | Preview segment rules
*SegmentsApi* | [**updateSegment**](docs/Api/SegmentsApi.md#updatesegment) | **PATCH** /segments/{segment} | Update segment
*SuppressionsApi* | [**createSuppression**](docs/Api/SuppressionsApi.md#createsuppression) | **POST** /suppressions | Create suppression
*SuppressionsApi* | [**deleteSuppression**](docs/Api/SuppressionsApi.md#deletesuppression) | **DELETE** /suppressions/{suppression} | Delete suppression
*SuppressionsApi* | [**listSuppressions**](docs/Api/SuppressionsApi.md#listsuppressions) | **GET** /suppressions | List suppressions
*SuppressionsApi* | [**restoreSuppression**](docs/Api/SuppressionsApi.md#restoresuppression) | **POST** /suppressions/{suppression}/restore | Restore suppression
*TagsApi* | [**bulkAssignTags**](docs/Api/TagsApi.md#bulkassigntags) | **POST** /tags/bulk-assign | Bulk assign tags
*TagsApi* | [**bulkRemoveTags**](docs/Api/TagsApi.md#bulkremovetags) | **POST** /tags/bulk-remove | Bulk remove tags
*TagsApi* | [**createTag**](docs/Api/TagsApi.md#createtag) | **POST** /tags | Create tag
*TagsApi* | [**deleteTag**](docs/Api/TagsApi.md#deletetag) | **DELETE** /tags/{tag} | Delete tag
*TagsApi* | [**getTag**](docs/Api/TagsApi.md#gettag) | **GET** /tags/{tag} | Get tag
*TagsApi* | [**listTags**](docs/Api/TagsApi.md#listtags) | **GET** /tags | List tags
*TagsApi* | [**updateTag**](docs/Api/TagsApi.md#updatetag) | **PATCH** /tags/{tag} | Update tag
*TemplatesApi* | [**createTemplate**](docs/Api/TemplatesApi.md#createtemplate) | **POST** /templates | Create template
*TemplatesApi* | [**deleteTemplate**](docs/Api/TemplatesApi.md#deletetemplate) | **DELETE** /templates/{template} | Delete template
*TemplatesApi* | [**duplicateTemplate**](docs/Api/TemplatesApi.md#duplicatetemplate) | **POST** /templates/{template}/duplicate | Duplicate template
*TemplatesApi* | [**getTemplate**](docs/Api/TemplatesApi.md#gettemplate) | **GET** /templates/{template} | Get template
*TemplatesApi* | [**listTemplates**](docs/Api/TemplatesApi.md#listtemplates) | **GET** /templates | List templates
*TemplatesApi* | [**previewPublishedTemplate**](docs/Api/TemplatesApi.md#previewpublishedtemplate) | **POST** /templates/preview | Preview published template
*TemplatesApi* | [**previewTemplate**](docs/Api/TemplatesApi.md#previewtemplate) | **POST** /templates/{template}/preview | Preview template
*TemplatesApi* | [**testTemplate**](docs/Api/TemplatesApi.md#testtemplate) | **POST** /templates/{template}/test | Test template
*TemplatesApi* | [**updateTemplate**](docs/Api/TemplatesApi.md#updatetemplate) | **PATCH** /templates/{template} | Update template
*WebhooksApi* | [**createWebhook**](docs/Api/WebhooksApi.md#createwebhook) | **POST** /webhooks | Create webhook
*WebhooksApi* | [**deleteWebhook**](docs/Api/WebhooksApi.md#deletewebhook) | **DELETE** /webhooks/{webhook} | Delete webhook
*WebhooksApi* | [**disableWebhook**](docs/Api/WebhooksApi.md#disablewebhook) | **POST** /webhooks/{webhook}/disable | Disable webhook
*WebhooksApi* | [**enableWebhook**](docs/Api/WebhooksApi.md#enablewebhook) | **POST** /webhooks/{webhook}/enable | Enable webhook
*WebhooksApi* | [**getWebhook**](docs/Api/WebhooksApi.md#getwebhook) | **GET** /webhooks/{webhook} | Get webhook
*WebhooksApi* | [**getWebhookDelivery**](docs/Api/WebhooksApi.md#getwebhookdelivery) | **GET** /webhook-deliveries/{webhookDelivery} | Get webhook delivery
*WebhooksApi* | [**listWebhookDeliveries**](docs/Api/WebhooksApi.md#listwebhookdeliveries) | **GET** /webhooks/{webhook}/deliveries | List webhook deliveries
*WebhooksApi* | [**listWebhooks**](docs/Api/WebhooksApi.md#listwebhooks) | **GET** /webhooks | List webhooks
*WebhooksApi* | [**replayWebhookDeliveries**](docs/Api/WebhooksApi.md#replaywebhookdeliveries) | **POST** /webhooks/{webhook}/replay | Replay webhook deliveries
*WebhooksApi* | [**replayWebhookDelivery**](docs/Api/WebhooksApi.md#replaywebhookdelivery) | **POST** /webhook-deliveries/{webhookDelivery}/replay | Replay webhook delivery
*WebhooksApi* | [**rotateWebhookSecret**](docs/Api/WebhooksApi.md#rotatewebhooksecret) | **POST** /webhooks/{webhook}/rotate-secret | Rotate webhook secret
*WebhooksApi* | [**testWebhook**](docs/Api/WebhooksApi.md#testwebhook) | **POST** /webhooks/{webhook}/test | Test webhook
*WebhooksApi* | [**updateWebhook**](docs/Api/WebhooksApi.md#updatewebhook) | **PATCH** /webhooks/{webhook} | Update webhook

## Models

- [AddAudienceMembers200Response](docs/Model/AddAudienceMembers200Response.md)
- [AddAudienceMembers200ResponseData](docs/Model/AddAudienceMembers200ResponseData.md)
- [AddContactsToList200Response](docs/Model/AddContactsToList200Response.md)
- [AnalyticsCampaigns](docs/Model/AnalyticsCampaigns.md)
- [AnalyticsCampaignsCampaignsInner](docs/Model/AnalyticsCampaignsCampaignsInner.md)
- [AnalyticsCampaignsResponse](docs/Model/AnalyticsCampaignsResponse.md)
- [AnalyticsDomains](docs/Model/AnalyticsDomains.md)
- [AnalyticsDomainsDomainsInner](docs/Model/AnalyticsDomainsDomainsInner.md)
- [AnalyticsDomainsResponse](docs/Model/AnalyticsDomainsResponse.md)
- [AnalyticsEngagement](docs/Model/AnalyticsEngagement.md)
- [AnalyticsEngagementResponse](docs/Model/AnalyticsEngagementResponse.md)
- [AnalyticsMessages](docs/Model/AnalyticsMessages.md)
- [AnalyticsMessagesDailyInner](docs/Model/AnalyticsMessagesDailyInner.md)
- [AnalyticsMessagesResponse](docs/Model/AnalyticsMessagesResponse.md)
- [AnalyticsMessagesTotals](docs/Model/AnalyticsMessagesTotals.md)
- [AnalyticsOverview](docs/Model/AnalyticsOverview.md)
- [AnalyticsOverviewDailySeriesInner](docs/Model/AnalyticsOverviewDailySeriesInner.md)
- [AnalyticsOverviewRecentActivityInner](docs/Model/AnalyticsOverviewRecentActivityInner.md)
- [AnalyticsOverviewResponse](docs/Model/AnalyticsOverviewResponse.md)
- [AnalyticsOverviewTopCampaignsInner](docs/Model/AnalyticsOverviewTopCampaignsInner.md)
- [AnalyticsOverviewTopLinksInner](docs/Model/AnalyticsOverviewTopLinksInner.md)
- [AnalyticsProjects](docs/Model/AnalyticsProjects.md)
- [AnalyticsProjectsProjectsInner](docs/Model/AnalyticsProjectsProjectsInner.md)
- [AnalyticsProjectsResponse](docs/Model/AnalyticsProjectsResponse.md)
- [AnalyticsProviders](docs/Model/AnalyticsProviders.md)
- [AnalyticsProvidersProvidersInner](docs/Model/AnalyticsProvidersProvidersInner.md)
- [AnalyticsProvidersResponse](docs/Model/AnalyticsProvidersResponse.md)
- [ApiKeyListResponse](docs/Model/ApiKeyListResponse.md)
- [ApiKeyResource](docs/Model/ApiKeyResource.md)
- [ApiKeyResponse](docs/Model/ApiKeyResponse.md)
- [AudienceCollection](docs/Model/AudienceCollection.md)
- [AudienceResource](docs/Model/AudienceResource.md)
- [AudienceResponse](docs/Model/AudienceResponse.md)
- [BulkAssignTags200Response](docs/Model/BulkAssignTags200Response.md)
- [BulkAssignTags200ResponseData](docs/Model/BulkAssignTags200ResponseData.md)
- [BulkContactIdsRequest](docs/Model/BulkContactIdsRequest.md)
- [BulkDeleteContacts200Response](docs/Model/BulkDeleteContacts200Response.md)
- [BulkDeleteContacts200ResponseData](docs/Model/BulkDeleteContacts200ResponseData.md)
- [BulkRemoveTags200Response](docs/Model/BulkRemoveTags200Response.md)
- [BulkRestoreContacts200Response](docs/Model/BulkRestoreContacts200Response.md)
- [BulkRestoreContacts200ResponseData](docs/Model/BulkRestoreContacts200ResponseData.md)
- [BulkTagContactsRequest](docs/Model/BulkTagContactsRequest.md)
- [BulkUpdateContacts200Response](docs/Model/BulkUpdateContacts200Response.md)
- [BulkUpdateContacts200ResponseData](docs/Model/BulkUpdateContacts200ResponseData.md)
- [BulkUpdateContactsRequest](docs/Model/BulkUpdateContactsRequest.md)
- [CampaignActivity](docs/Model/CampaignActivity.md)
- [CampaignActivityCollection](docs/Model/CampaignActivityCollection.md)
- [CampaignActivityEvent](docs/Model/CampaignActivityEvent.md)
- [CampaignAnalytics](docs/Model/CampaignAnalytics.md)
- [CampaignAnalyticsResponse](docs/Model/CampaignAnalyticsResponse.md)
- [CampaignCollection](docs/Model/CampaignCollection.md)
- [CampaignEvent](docs/Model/CampaignEvent.md)
- [CampaignEventsResponse](docs/Model/CampaignEventsResponse.md)
- [CampaignLink](docs/Model/CampaignLink.md)
- [CampaignLinksResponse](docs/Model/CampaignLinksResponse.md)
- [CampaignPreview](docs/Model/CampaignPreview.md)
- [CampaignPreviewResponse](docs/Model/CampaignPreviewResponse.md)
- [CampaignRecipient](docs/Model/CampaignRecipient.md)
- [CampaignRecipientCollection](docs/Model/CampaignRecipientCollection.md)
- [CampaignRecipientPreview](docs/Model/CampaignRecipientPreview.md)
- [CampaignRecipientPreviewResponse](docs/Model/CampaignRecipientPreviewResponse.md)
- [CampaignRecipientStatus](docs/Model/CampaignRecipientStatus.md)
- [CampaignResource](docs/Model/CampaignResource.md)
- [CampaignResponse](docs/Model/CampaignResponse.md)
- [CampaignStatistics](docs/Model/CampaignStatistics.md)
- [CampaignStatisticsResponse](docs/Model/CampaignStatisticsResponse.md)
- [CampaignStatus](docs/Model/CampaignStatus.md)
- [CampaignTimeline](docs/Model/CampaignTimeline.md)
- [CampaignTimelineResponse](docs/Model/CampaignTimelineResponse.md)
- [CampaignValidation](docs/Model/CampaignValidation.md)
- [CampaignValidationResponse](docs/Model/CampaignValidationResponse.md)
- [ConfigureContactImportRequest](docs/Model/ConfigureContactImportRequest.md)
- [ContactCollection](docs/Model/ContactCollection.md)
- [ContactResource](docs/Model/ContactResource.md)
- [ContactResponse](docs/Model/ContactResponse.md)
- [CreateApiKeyRequest](docs/Model/CreateApiKeyRequest.md)
- [CreateCampaignRequest](docs/Model/CreateCampaignRequest.md)
- [CreateContactRequest](docs/Model/CreateContactRequest.md)
- [CreateCustomFieldRequest](docs/Model/CreateCustomFieldRequest.md)
- [CreateDomainRequest](docs/Model/CreateDomainRequest.md)
- [CreateListRequest](docs/Model/CreateListRequest.md)
- [CreateProjectRequest](docs/Model/CreateProjectRequest.md)
- [CreateSegmentRequest](docs/Model/CreateSegmentRequest.md)
- [CreateSegmentRequestRules](docs/Model/CreateSegmentRequestRules.md)
- [CreateSuppressionRequest](docs/Model/CreateSuppressionRequest.md)
- [CreateTagRequest](docs/Model/CreateTagRequest.md)
- [CreateTemplateRequest](docs/Model/CreateTemplateRequest.md)
- [CreateTemplateRequestBranding](docs/Model/CreateTemplateRequestBranding.md)
- [CreateTemplateRequestVariablesInner](docs/Model/CreateTemplateRequestVariablesInner.md)
- [CreateWebhookRequest](docs/Model/CreateWebhookRequest.md)
- [CustomField](docs/Model/CustomField.md)
- [CustomFieldCollection](docs/Model/CustomFieldCollection.md)
- [CustomFieldResponse](docs/Model/CustomFieldResponse.md)
- [CustomFieldType](docs/Model/CustomFieldType.md)
- [DNSRecord](docs/Model/DNSRecord.md)
- [DeleteResponse](docs/Model/DeleteResponse.md)
- [DeliveryLog](docs/Model/DeliveryLog.md)
- [DomainListResponse](docs/Model/DomainListResponse.md)
- [DomainResource](docs/Model/DomainResource.md)
- [DomainResponse](docs/Model/DomainResponse.md)
- [DuplicateCampaignRequest](docs/Model/DuplicateCampaignRequest.md)
- [DuplicateTemplateRequest](docs/Model/DuplicateTemplateRequest.md)
- [EmailAttachment](docs/Model/EmailAttachment.md)
- [EventListResponse](docs/Model/EventListResponse.md)
- [EventResponse](docs/Model/EventResponse.md)
- [ExportContactsRequest](docs/Model/ExportContactsRequest.md)
- [ExportJob](docs/Model/ExportJob.md)
- [ExportJobResponse](docs/Model/ExportJobResponse.md)
- [ImportContactsRequest](docs/Model/ImportContactsRequest.md)
- [ImportJob](docs/Model/ImportJob.md)
- [ImportJobCollection](docs/Model/ImportJobCollection.md)
- [ImportJobDetail](docs/Model/ImportJobDetail.md)
- [ImportJobDetailResponse](docs/Model/ImportJobDetailResponse.md)
- [ImportJobResponse](docs/Model/ImportJobResponse.md)
- [ImportProgress](docs/Model/ImportProgress.md)
- [InlineObject](docs/Model/InlineObject.md)
- [InlineObject1](docs/Model/InlineObject1.md)
- [ListCollection](docs/Model/ListCollection.md)
- [ListContactsMembershipRequest](docs/Model/ListContactsMembershipRequest.md)
- [ListResource](docs/Model/ListResource.md)
- [ListResponse](docs/Model/ListResponse.md)
- [Message](docs/Model/Message.md)
- [MessageDetailResponse](docs/Model/MessageDetailResponse.md)
- [MessageEventsResponse](docs/Model/MessageEventsResponse.md)
- [MessageListResponse](docs/Model/MessageListResponse.md)
- [MessageStatus](docs/Model/MessageStatus.md)
- [PaginationMeta](docs/Model/PaginationMeta.md)
- [PreviewSegmentRequest](docs/Model/PreviewSegmentRequest.md)
- [PreviewSegmentRequestRules](docs/Model/PreviewSegmentRequestRules.md)
- [PreviewSegmentRequestRulesRulesInner](docs/Model/PreviewSegmentRequestRulesRulesInner.md)
- [PreviewTemplateByIdRequest](docs/Model/PreviewTemplateByIdRequest.md)
- [PreviewTemplateRequest](docs/Model/PreviewTemplateRequest.md)
- [ProjectListResponse](docs/Model/ProjectListResponse.md)
- [ProjectResource](docs/Model/ProjectResource.md)
- [ProjectResponse](docs/Model/ProjectResponse.md)
- [RemoveAudienceMembers200Response](docs/Model/RemoveAudienceMembers200Response.md)
- [RemoveAudienceMembers200ResponseData](docs/Model/RemoveAudienceMembers200ResponseData.md)
- [RemoveContactsFromList200Response](docs/Model/RemoveContactsFromList200Response.md)
- [ReplayWebhookRequest](docs/Model/ReplayWebhookRequest.md)
- [ScheduleCampaignRequest](docs/Model/ScheduleCampaignRequest.md)
- [SegmentCollection](docs/Model/SegmentCollection.md)
- [SegmentCountResponse](docs/Model/SegmentCountResponse.md)
- [SegmentCountResponseData](docs/Model/SegmentCountResponseData.md)
- [SegmentPreviewResponse](docs/Model/SegmentPreviewResponse.md)
- [SegmentPreviewResponseData](docs/Model/SegmentPreviewResponseData.md)
- [SegmentResource](docs/Model/SegmentResource.md)
- [SegmentResponse](docs/Model/SegmentResponse.md)
- [SendEmailRequest](docs/Model/SendEmailRequest.md)
- [SendEmailRequestAttachmentsInner](docs/Model/SendEmailRequestAttachmentsInner.md)
- [SendEmailResponse](docs/Model/SendEmailResponse.md)
- [Suppression](docs/Model/Suppression.md)
- [SuppressionListResponse](docs/Model/SuppressionListResponse.md)
- [SuppressionReason](docs/Model/SuppressionReason.md)
- [SuppressionResponse](docs/Model/SuppressionResponse.md)
- [TagCollection](docs/Model/TagCollection.md)
- [TagResource](docs/Model/TagResource.md)
- [TagResponse](docs/Model/TagResponse.md)
- [TemplateLayoutStyle](docs/Model/TemplateLayoutStyle.md)
- [TemplateListResponse](docs/Model/TemplateListResponse.md)
- [TemplatePreview](docs/Model/TemplatePreview.md)
- [TemplatePreviewResponse](docs/Model/TemplatePreviewResponse.md)
- [TemplateResource](docs/Model/TemplateResource.md)
- [TemplateResponse](docs/Model/TemplateResponse.md)
- [TemplateStatus](docs/Model/TemplateStatus.md)
- [TemplateTestResponse](docs/Model/TemplateTestResponse.md)
- [TemplateTestResponseData](docs/Model/TemplateTestResponseData.md)
- [TemplateVariable](docs/Model/TemplateVariable.md)
- [TemplateVariableType](docs/Model/TemplateVariableType.md)
- [TestTemplateRequest](docs/Model/TestTemplateRequest.md)
- [TestWebhookRequest](docs/Model/TestWebhookRequest.md)
- [TimelineEvent](docs/Model/TimelineEvent.md)
- [UpdateApiKeyRequest](docs/Model/UpdateApiKeyRequest.md)
- [UpdateCampaignRequest](docs/Model/UpdateCampaignRequest.md)
- [UpdateContactRequest](docs/Model/UpdateContactRequest.md)
- [UpdateCustomFieldRequest](docs/Model/UpdateCustomFieldRequest.md)
- [UpdateListRequest](docs/Model/UpdateListRequest.md)
- [UpdateProjectRequest](docs/Model/UpdateProjectRequest.md)
- [UpdateSegmentRequest](docs/Model/UpdateSegmentRequest.md)
- [UpdateSegmentRequestRules](docs/Model/UpdateSegmentRequestRules.md)
- [UpdateTagRequest](docs/Model/UpdateTagRequest.md)
- [UpdateTemplateRequest](docs/Model/UpdateTemplateRequest.md)
- [UpdateWebhookRequest](docs/Model/UpdateWebhookRequest.md)
- [Webhook](docs/Model/Webhook.md)
- [WebhookDelivery](docs/Model/WebhookDelivery.md)
- [WebhookDeliveryListResponse](docs/Model/WebhookDeliveryListResponse.md)
- [WebhookDeliveryMessage](docs/Model/WebhookDeliveryMessage.md)
- [WebhookDeliveryResponse](docs/Model/WebhookDeliveryResponse.md)
- [WebhookDeliveryStatus](docs/Model/WebhookDeliveryStatus.md)
- [WebhookDeliveryWebhook](docs/Model/WebhookDeliveryWebhook.md)
- [WebhookLastDelivery](docs/Model/WebhookLastDelivery.md)
- [WebhookListResponse](docs/Model/WebhookListResponse.md)
- [WebhookProject](docs/Model/WebhookProject.md)
- [WebhookReplayResponse](docs/Model/WebhookReplayResponse.md)
- [WebhookReplayResponseData](docs/Model/WebhookReplayResponseData.md)
- [WebhookResponse](docs/Model/WebhookResponse.md)
- [WebhookRetryPolicy](docs/Model/WebhookRetryPolicy.md)
- [WebhookSecretResponse](docs/Model/WebhookSecretResponse.md)
- [WebhookWithSecret](docs/Model/WebhookWithSecret.md)

## Authorization

Authentication schemes defined for the API:
### bearerAuth

- **Type**: Bearer authentication (API Key)

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.0.0`
    - Generator version: `7.23.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
