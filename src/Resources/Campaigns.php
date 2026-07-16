<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTime;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\CampaignAnalyticsApi;
use OpenAPI\Client\Api\CampaignEventsApi;
use OpenAPI\Client\Api\CampaignLifecycleApi;
use OpenAPI\Client\Api\CampaignsApi;
use OpenAPI\Client\Model\CreateCampaignRequest;
use OpenAPI\Client\Model\DuplicateCampaignRequest;
use OpenAPI\Client\Model\ScheduleCampaignRequest;
use OpenAPI\Client\Model\UpdateCampaignRequest;

/**
 * Campaigns resource.
 *
 * Provides a cohesive campaign API over the generated campaigns, lifecycle,
 * analytics, and events clients.
 *
 * @example
 * $campaign = $mm->campaigns()->create([
 *     'name' => 'Welcome series',
 *     'subject' => 'Welcome aboard',
 *     'template_id' => $templateId,
 *     'segment_id' => $segmentId,
 * ]);
 *
 * $mm->campaigns()->schedule($campaign->data()['uuid'], [
 *     'scheduled_at' => '2026-08-01T09:00:00+00:00',
 *     'timezone' => 'UTC',
 * ]);
 */
final class Campaigns extends BaseResource
{
    private ?CampaignsApi $campaignsApi = null;

    private ?CampaignLifecycleApi $lifecycleApi = null;

    private ?CampaignAnalyticsApi $analyticsApi = null;

    private ?CampaignEventsApi $eventsApi = null;

    /**
     * Create a campaign.
     *
     * The MailerMine create endpoint accepts only a name. Extra configuration
     * fields are applied immediately through a follow-up update so callers can
     * create a fully configured draft in one SDK call.
     *
     * @param array{
     *     name: string,
     *     subject?: string|null,
     *     preview_text?: string|null,
     *     preheader?: string|null,
     *     from_name?: string|null,
     *     from_email?: string|null,
     *     reply_to?: string|null,
     *     template_uuid?: string|null,
     *     template_id?: string|null,
     *     segment_uuid?: string|null,
     *     segment_id?: string|null,
     *     audience_id?: string|null,
     *     send_immediately?: bool,
     *     scheduled_at?: string|DateTimeInterface|null,
     *     timezone?: string|null,
     *     builder_step?: int
     * } $parameters Campaign attributes.
     * @return Response The created campaign.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $campaign = $mm->campaigns()->create([
     *     'name' => 'March Newsletter',
     *     'subject' => 'What is new this month',
     *     'template_id' => $templateId,
     *     'segment_id' => $segmentId,
     * ]);
     */
    public function create(array $parameters): Response
    {
        $parameters = $this->normalizeCampaignParameters($parameters);
        $name = $parameters['name'] ?? null;

        if (!is_string($name) || $name === '') {
            throw new InvalidArgumentException('The name field is required.');
        }

        $created = $this->executeRequest(
            $this->campaignsApi()->createCampaignRequest(
                RequestBuilder::make(CreateCampaignRequest::class, ['name' => $name])
            )
        );

        $configuration = $this->extractConfigurationParameters($parameters);

        if ($configuration === []) {
            return $created;
        }

        $campaignId = $this->campaignIdFromResponse($created);

        return $this->update($campaignId, $configuration);
    }

    /**
     * List campaigns with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Campaign list filters.
     * @return Collection A collection of campaigns with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $campaigns = $mm->campaigns()->list(['status' => 'draft']);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->campaignsApi()->listCampaignsRequest(
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 15,
        ));
    }

    /**
     * Retrieve a campaign by UUID.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The requested campaign.
     *
     * @throws ApiException When the campaign cannot be retrieved.
     *
     * @example
     * $campaign = $mm->campaigns()->get($campaignId);
     */
    public function get(string $campaignId): Response
    {
        return $this->executeRequest($this->campaignsApi()->getCampaignRequest($campaignId));
    }

    /**
     * Update an editable campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param array{
     *     name?: string,
     *     subject?: string|null,
     *     preview_text?: string|null,
     *     preheader?: string|null,
     *     from_name?: string|null,
     *     from_email?: string|null,
     *     reply_to?: string|null,
     *     template_uuid?: string|null,
     *     template_id?: string|null,
     *     segment_uuid?: string|null,
     *     segment_id?: string|null,
     *     audience_id?: string|null,
     *     send_immediately?: bool,
     *     scheduled_at?: string|DateTimeInterface|null,
     *     timezone?: string|null,
     *     builder_step?: int
     * } $parameters Attributes to update.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $campaign = $mm->campaigns()->update($campaignId, [
     *     'subject' => 'Updated subject',
     * ]);
     */
    public function update(string $campaignId, array $parameters): Response
    {
        $request = RequestBuilder::make(
            UpdateCampaignRequest::class,
            $this->normalizeCampaignParameters($parameters),
        );

        return $this->executeRequest(
            $this->campaignsApi()->updateCampaignRequest($campaignId, $request)
        );
    }

    /**
     * Soft-delete a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the campaign cannot be deleted.
     *
     * @example
     * $mm->campaigns()->delete($campaignId);
     */
    public function delete(string $campaignId): Response
    {
        return $this->executeRequest($this->campaignsApi()->deleteCampaignRequest($campaignId));
    }

    /**
     * Duplicate a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  array{include_schedule?: bool}  $parameters  Duplicate options.
     * @return Response The duplicated campaign.
     *
     * @throws ApiException When the campaign cannot be duplicated.
     *
     * @example
     * $copy = $mm->campaigns()->duplicate($campaignId);
     */
    public function duplicate(string $campaignId, array $parameters = []): Response
    {
        $request = $parameters === []
            ? null
            : RequestBuilder::make(DuplicateCampaignRequest::class, $parameters);

        return $this->executeRequest(
            $this->lifecycleApi()->duplicateCampaignRequest($campaignId, $request)
        );
    }

    /**
     * Preview rendered campaign content.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Subject, HTML, text, and preview text.
     *
     * @throws ApiException When the preview cannot be generated.
     *
     * @example
     * $preview = $mm->campaigns()->preview($campaignId);
     */
    public function preview(string $campaignId): Response
    {
        return $this->executeRequest($this->campaignsApi()->previewCampaignRequest($campaignId));
    }

    /**
     * Render campaign content.
     *
     * Alias of {@see preview()} for content workflows.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Subject, HTML, text, and preview text.
     *
     * @throws ApiException When the campaign cannot be rendered.
     *
     * @example
     * $html = $mm->campaigns()->render($campaignId)->data()['html'];
     */
    public function render(string $campaignId): Response
    {
        return $this->preview($campaignId);
    }

    /**
     * Validate campaign readiness.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Validation result.
     *
     * @throws ApiException When validation fails to run.
     *
     * @example
     * $validation = $mm->campaigns()->validate($campaignId);
     */
    public function validate(string $campaignId): Response
    {
        return $this->executeRequest($this->campaignsApi()->validateCampaignRequest($campaignId));
    }

    /**
     * Mark a campaign as ready to send or schedule.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the campaign cannot be marked ready.
     *
     * @example
     * $mm->campaigns()->markReady($campaignId);
     */
    public function markReady(string $campaignId): Response
    {
        return $this->executeRequest($this->lifecycleApi()->readyCampaignRequest($campaignId));
    }

    /**
     * Send a ready campaign immediately.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The sending campaign.
     *
     * @throws ApiException When the campaign cannot be sent.
     *
     * @example
     * $mm->campaigns()->send($campaignId);
     */
    public function send(string $campaignId): Response
    {
        return $this->executeRequest($this->lifecycleApi()->sendCampaignRequest($campaignId));
    }

    /**
     * Schedule a campaign for later delivery.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param array{
     *     send_immediately?: bool,
     *     scheduled_at?: string|DateTimeInterface|null,
     *     timezone?: string
     * } $parameters Schedule options. `timezone` defaults to `UTC`.
     * @return Response The scheduled campaign.
     *
     * @throws ApiException When the campaign cannot be scheduled.
     *
     * @example
     * $mm->campaigns()->schedule($campaignId, [
     *     'scheduled_at' => '2026-08-01T09:00:00+00:00',
     *     'timezone' => 'America/New_York',
     * ]);
     */
    public function schedule(string $campaignId, array $parameters = []): Response
    {
        $request = RequestBuilder::make(
            ScheduleCampaignRequest::class,
            $this->normalizeScheduleParameters($parameters),
        );

        return $this->executeRequest(
            $this->lifecycleApi()->scheduleCampaignRequest($campaignId, $request)
        );
    }

    /**
     * Reschedule an already scheduled campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param array{
     *     send_immediately?: bool,
     *     scheduled_at?: string|DateTimeInterface|null,
     *     timezone?: string
     * } $parameters New schedule options.
     * @return Response The rescheduled campaign.
     *
     * @throws ApiException When the campaign cannot be rescheduled.
     *
     * @example
     * $mm->campaigns()->reschedule($campaignId, [
     *     'scheduled_at' => '2026-08-02T10:00:00+00:00',
     *     'timezone' => 'UTC',
     * ]);
     */
    public function reschedule(string $campaignId, array $parameters = []): Response
    {
        return $this->schedule($campaignId, $parameters);
    }

    /**
     * Clear a pending schedule by updating schedule fields.
     *
     * MailerMine does not expose a dedicated unschedule endpoint. This helper
     * clears `scheduled_at` through the campaign update API.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  array{timezone?: string|null}  $parameters  Optional timezone retained on the campaign.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the schedule cannot be cleared.
     *
     * @example
     * $mm->campaigns()->unschedule($campaignId);
     */
    public function unschedule(string $campaignId, array $parameters = []): Response
    {
        $payload = [
            'send_immediately' => false,
            'scheduled_at' => null,
        ];

        if (array_key_exists('timezone', $parameters)) {
            $payload['timezone'] = $parameters['timezone'];
        }

        return $this->update($campaignId, $payload);
    }

    /**
     * Send a campaign immediately through the schedule endpoint.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  array{timezone?: string}  $parameters  Optional timezone (defaults to `UTC`).
     * @return Response The campaign queued for immediate delivery.
     *
     * @throws ApiException When the campaign cannot be sent.
     *
     * @example
     * $mm->campaigns()->sendNow($campaignId);
     */
    public function sendNow(string $campaignId, array $parameters = []): Response
    {
        return $this->schedule($campaignId, [
            'send_immediately' => true,
            'timezone' => $parameters['timezone'] ?? 'UTC',
        ]);
    }

    /**
     * Cancel a pending schedule.
     *
     * Alias of {@see cancel()} for scheduling workflows.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The cancelled campaign.
     *
     * @throws ApiException When the schedule cannot be cancelled.
     *
     * @example
     * $mm->campaigns()->cancelSchedule($campaignId);
     */
    public function cancelSchedule(string $campaignId): Response
    {
        return $this->cancel($campaignId);
    }

    /**
     * Pause a sending campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The paused campaign.
     *
     * @throws ApiException When the campaign cannot be paused.
     *
     * @example
     * $mm->campaigns()->pause($campaignId);
     */
    public function pause(string $campaignId): Response
    {
        return $this->executeRequest($this->lifecycleApi()->pauseCampaignRequest($campaignId));
    }

    /**
     * Resume a paused campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The resumed campaign.
     *
     * @throws ApiException When the campaign cannot be resumed.
     *
     * @example
     * $mm->campaigns()->resume($campaignId);
     */
    public function resume(string $campaignId): Response
    {
        return $this->executeRequest($this->lifecycleApi()->resumeCampaignRequest($campaignId));
    }

    /**
     * Cancel a scheduled or sending campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The cancelled campaign.
     *
     * @throws ApiException When the campaign cannot be cancelled.
     *
     * @example
     * $mm->campaigns()->cancel($campaignId);
     */
    public function cancel(string $campaignId): Response
    {
        return $this->executeRequest($this->lifecycleApi()->cancelCampaignRequest($campaignId));
    }

    /**
     * Archive a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The archived campaign.
     *
     * @throws ApiException When the campaign cannot be archived.
     *
     * @example
     * $mm->campaigns()->archive($campaignId);
     */
    public function archive(string $campaignId): Response
    {
        return $this->executeRequest($this->lifecycleApi()->archiveCampaignRequest($campaignId));
    }

    /**
     * Restore an archived or soft-deleted campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The restored campaign.
     *
     * @throws ApiException When the campaign cannot be restored.
     *
     * @example
     * $mm->campaigns()->restore($campaignId);
     */
    public function restore(string $campaignId): Response
    {
        return $this->executeRequest($this->lifecycleApi()->restoreCampaignRequest($campaignId));
    }

    /**
     * Attach an audience (segment) to a campaign.
     *
     * Campaigns currently select recipients through `segment_uuid`.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  string  $audienceId  Segment or audience UUID.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the audience cannot be attached.
     *
     * @example
     * $mm->campaigns()->addAudience($campaignId, $segmentId);
     */
    public function addAudience(string $campaignId, string $audienceId): Response
    {
        return $this->update($campaignId, ['segment_uuid' => $audienceId]);
    }

    /**
     * Remove the attached audience from a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the audience cannot be removed.
     *
     * @example
     * $mm->campaigns()->removeAudience($campaignId);
     */
    public function removeAudience(string $campaignId): Response
    {
        return $this->update($campaignId, ['segment_uuid' => null]);
    }

    /**
     * Attach a segment to a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  string  $segmentId  Segment UUID.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the segment cannot be attached.
     *
     * @example
     * $mm->campaigns()->addSegment($campaignId, $segmentId);
     */
    public function addSegment(string $campaignId, string $segmentId): Response
    {
        return $this->update($campaignId, ['segment_uuid' => $segmentId]);
    }

    /**
     * Remove the attached segment from a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the segment cannot be removed.
     *
     * @example
     * $mm->campaigns()->removeSegment($campaignId);
     */
    public function removeSegment(string $campaignId): Response
    {
        return $this->update($campaignId, ['segment_uuid' => null]);
    }

    /**
     * Estimate recipient counts for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Count summary derived from recipient preview.
     *
     * @throws ApiException When recipients cannot be estimated.
     *
     * @example
     * $count = $mm->campaigns()->recipientCount($campaignId)->data()['count'];
     */
    public function recipientCount(string $campaignId): Response
    {
        $preview = $this->previewRecipients($campaignId);
        $data = $preview->data();
        $data = is_array($data) ? $data : [];

        return Response::from([
            'success' => $preview->success() ?? true,
            'message' => $preview->message() ?? 'OK',
            'data' => [
                'count' => $data['estimated_count'] ?? $data['count'] ?? 0,
                'estimated_count' => $data['estimated_count'] ?? null,
                'subscribed_count' => $data['subscribed_count'] ?? null,
                'unsubscribed_count' => $data['unsubscribed_count'] ?? null,
                'suppressed_count' => $data['suppressed_count'] ?? null,
            ],
        ]);
    }

    /**
     * Preview estimated recipients for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Recipient estimate and sample contacts.
     *
     * @throws ApiException When recipients cannot be previewed.
     *
     * @example
     * $preview = $mm->campaigns()->previewRecipients($campaignId);
     */
    public function previewRecipients(string $campaignId): Response
    {
        return $this->executeRequest(
            $this->campaignsApi()->previewCampaignRecipientsRequest($campaignId)
        );
    }

    /**
     * List campaign recipients with optional filters.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param array{
     *     search?: string,
     *     status?: string,
     *     page?: int
     * } $filters Recipient filters.
     * @return Collection A collection of recipients with pagination.
     *
     * @throws ApiException When recipients cannot be listed.
     *
     * @example
     * $recipients = $mm->campaigns()->recipients($campaignId, ['status' => 'delivered']);
     */
    public function recipients(string $campaignId, array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->eventsApi()->campaignRecipientsRequest(
            $campaignId,
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            isset($filters['page']) ? (int) $filters['page'] : 1,
        ));
    }

    /**
     * Set the campaign template.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  string  $templateId  Template UUID.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the template cannot be attached.
     *
     * @example
     * $mm->campaigns()->setTemplate($campaignId, $templateId);
     */
    public function setTemplate(string $campaignId, string $templateId): Response
    {
        return $this->update($campaignId, ['template_uuid' => $templateId]);
    }

    /**
     * Set the campaign subject.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  string  $subject  Email subject.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the subject cannot be updated.
     *
     * @example
     * $mm->campaigns()->setSubject($campaignId, 'Welcome aboard');
     */
    public function setSubject(string $campaignId, string $subject): Response
    {
        return $this->update($campaignId, ['subject' => $subject]);
    }

    /**
     * Set the campaign sender.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  array{from_name?: string|null, from_email?: string|null}|string  $sender
     *                                                                                   Associative sender fields, or an email string.
     * @param  string|null  $fromName  Optional display name when `$sender` is an email string.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the sender cannot be updated.
     *
     * @example
     * $mm->campaigns()->setSender($campaignId, [
     *     'from_name' => 'MailerMine',
     *     'from_email' => 'hello@mailermine.com',
     * ]);
     */
    public function setSender(string $campaignId, array|string $sender, ?string $fromName = null): Response
    {
        if (is_string($sender)) {
            $payload = ['from_email' => $sender];

            if ($fromName !== null) {
                $payload['from_name'] = $fromName;
            }

            return $this->update($campaignId, $payload);
        }

        return $this->update($campaignId, array_intersect_key($sender, array_flip([
            'from_name',
            'from_email',
        ])));
    }

    /**
     * Set the campaign reply-to address.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  string|null  $replyTo  Reply-to email address.
     * @return Response The updated campaign.
     *
     * @throws ApiException When reply-to cannot be updated.
     *
     * @example
     * $mm->campaigns()->setReplyTo($campaignId, 'support@mailermine.com');
     */
    public function setReplyTo(string $campaignId, ?string $replyTo): Response
    {
        return $this->update($campaignId, ['reply_to' => $replyTo]);
    }

    /**
     * Set the campaign preheader / preview text.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @param  string|null  $preheader  Preview text shown in inbox clients.
     * @return Response The updated campaign.
     *
     * @throws ApiException When the preheader cannot be updated.
     *
     * @example
     * $mm->campaigns()->setPreheader($campaignId, 'Your weekly product digest');
     */
    public function setPreheader(string $campaignId, ?string $preheader): Response
    {
        return $this->update($campaignId, ['preview_text' => $preheader]);
    }

    /**
     * Retrieve a status summary for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Status fields projected from the campaign detail.
     *
     * @throws ApiException When the campaign cannot be retrieved.
     *
     * @example
     * $status = $mm->campaigns()->status($campaignId)->data()['status'];
     */
    public function status(string $campaignId): Response
    {
        $response = $this->get($campaignId);
        $campaign = $response->data();
        $campaign = is_array($campaign) ? $campaign : [];

        return Response::from([
            'success' => $response->success() ?? true,
            'message' => $response->message() ?? 'OK',
            'data' => array_intersect_key($campaign, array_flip([
                'uuid',
                'status',
                'status_label',
                'send_immediately',
                'scheduled_at',
                'timezone',
                'sent_at',
                'started_at',
                'completed_at',
                'last_processed_at',
            ])),
        ]);
    }

    /**
     * Retrieve campaign send progress.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Progress statistics.
     *
     * @throws ApiException When progress cannot be retrieved.
     *
     * @example
     * $progress = $mm->campaigns()->progress($campaignId);
     */
    public function progress(string $campaignId): Response
    {
        return $this->executeRequest(
            $this->lifecycleApi()->getCampaignProgressRequest($campaignId)
        );
    }

    /**
     * Retrieve delivery metrics for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Delivery-focused analytics slice.
     *
     * @throws ApiException When delivery metrics cannot be retrieved.
     *
     * @example
     * $delivery = $mm->campaigns()->delivery($campaignId);
     */
    public function delivery(string $campaignId): Response
    {
        return $this->analyticsSlice($campaignId, [
            'recipients',
            'queued',
            'sent',
            'delivered',
            'failed',
            'delivery_rate',
            'failure_rate',
            'average_delivery_time_seconds',
        ]);
    }

    /**
     * Retrieve campaign analytics.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Analytics payload, including top links when present.
     *
     * @throws ApiException When analytics cannot be retrieved.
     *
     * @example
     * $analytics = $mm->campaigns()->analytics($campaignId);
     */
    public function analytics(string $campaignId): Response
    {
        return $this->executeRequest(
            $this->analyticsApi()->campaignAnalyticsRequest($campaignId)
        );
    }

    /**
     * Retrieve open metrics for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Open-focused analytics slice.
     *
     * @throws ApiException When open metrics cannot be retrieved.
     *
     * @example
     * $opens = $mm->campaigns()->opens($campaignId);
     */
    public function opens(string $campaignId): Response
    {
        return $this->analyticsSlice($campaignId, [
            'opened',
            'unique_opens',
            'open_rate',
        ]);
    }

    /**
     * Retrieve click metrics for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Click-focused analytics slice.
     *
     * @throws ApiException When click metrics cannot be retrieved.
     *
     * @example
     * $clicks = $mm->campaigns()->clicks($campaignId);
     */
    public function clicks(string $campaignId): Response
    {
        return $this->analyticsSlice($campaignId, [
            'clicked',
            'unique_clicks',
            'click_rate',
        ]);
    }

    /**
     * Retrieve bounce metrics for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Bounce-focused analytics slice.
     *
     * @throws ApiException When bounce metrics cannot be retrieved.
     *
     * @example
     * $bounces = $mm->campaigns()->bounces($campaignId);
     */
    public function bounces(string $campaignId): Response
    {
        return $this->analyticsSlice($campaignId, [
            'bounced',
            'bounce_rate',
        ]);
    }

    /**
     * Retrieve complaint metrics for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Complaint-focused analytics slice.
     *
     * @throws ApiException When complaint metrics cannot be retrieved.
     *
     * @example
     * $complaints = $mm->campaigns()->complaints($campaignId);
     */
    public function complaints(string $campaignId): Response
    {
        return $this->analyticsSlice($campaignId, [
            'complained',
            'complaint_rate',
        ]);
    }

    /**
     * Retrieve unsubscribe metrics for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Unsubscribe-focused analytics slice.
     *
     * @throws ApiException When unsubscribe metrics cannot be retrieved.
     *
     * @example
     * $unsubscribes = $mm->campaigns()->unsubscribes($campaignId);
     */
    public function unsubscribes(string $campaignId): Response
    {
        return $this->analyticsSlice($campaignId, [
            'unsubscribed',
            'unsubscribe_rate',
        ]);
    }

    /**
     * Retrieve delivery count metrics for a campaign.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Response Delivery count analytics slice.
     *
     * @throws ApiException When delivery metrics cannot be retrieved.
     *
     * @example
     * $deliveries = $mm->campaigns()->deliveries($campaignId);
     */
    public function deliveries(string $campaignId): Response
    {
        return $this->analyticsSlice($campaignId, [
            'delivered',
            'delivery_rate',
            'sent',
            'failed',
        ]);
    }

    /**
     * Retrieve tracked campaign links.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Collection Tracked links.
     *
     * @throws ApiException When links cannot be retrieved.
     *
     * @example
     * $links = $mm->campaigns()->links($campaignId);
     */
    public function links(string $campaignId): Collection
    {
        return $this->executeCollectionRequest(
            $this->analyticsApi()->campaignLinksRequest($campaignId)
        );
    }

    /**
     * Retrieve campaign events.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Collection Campaign events.
     *
     * @throws ApiException When events cannot be retrieved.
     *
     * @example
     * $events = $mm->campaigns()->events($campaignId);
     */
    public function events(string $campaignId): Collection
    {
        return $this->executeCollectionRequest(
            $this->eventsApi()->campaignEventsRequest($campaignId)
        );
    }

    /**
     * Retrieve campaign activity entries.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Collection Campaign activities.
     *
     * @throws ApiException When activities cannot be retrieved.
     *
     * @example
     * $activity = $mm->campaigns()->activity($campaignId);
     */
    public function activity(string $campaignId): Collection
    {
        return $this->executeCollectionRequest(
            $this->eventsApi()->campaignActivitiesRequest($campaignId)
        );
    }

    /**
     * Retrieve the campaign timeline.
     *
     * @param  string  $campaignId  Campaign UUID.
     * @return Collection Timeline entries.
     *
     * @throws ApiException When the timeline cannot be retrieved.
     *
     * @example
     * $timeline = $mm->campaigns()->timeline($campaignId);
     */
    public function timeline(string $campaignId): Collection
    {
        return $this->executeCollectionRequest(
            $this->eventsApi()->campaignTimelineRequest($campaignId)
        );
    }

    /**
     * @param  list<string>  $keys
     */
    private function analyticsSlice(string $campaignId, array $keys): Response
    {
        $response = $this->analytics($campaignId);
        $data = $response->data();
        $data = is_array($data) ? $data : [];

        return Response::from([
            'success' => $response->success() ?? true,
            'message' => $response->message() ?? 'OK',
            'data' => array_intersect_key($data, array_flip($keys)),
        ]);
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    private function normalizeCampaignParameters(array $parameters): array
    {
        if (isset($parameters['template_id']) && !isset($parameters['template_uuid'])) {
            $parameters['template_uuid'] = $parameters['template_id'];
        }

        if (isset($parameters['segment_id']) && !isset($parameters['segment_uuid'])) {
            $parameters['segment_uuid'] = $parameters['segment_id'];
        }

        if (isset($parameters['audience_id']) && !isset($parameters['segment_uuid'])) {
            $parameters['segment_uuid'] = $parameters['audience_id'];
        }

        if (isset($parameters['preheader']) && !isset($parameters['preview_text'])) {
            $parameters['preview_text'] = $parameters['preheader'];
        }

        unset(
            $parameters['template_id'],
            $parameters['segment_id'],
            $parameters['audience_id'],
            $parameters['preheader'],
        );

        if (array_key_exists('scheduled_at', $parameters)) {
            $parameters['scheduled_at'] = $this->normalizeDateTime(
                $parameters['scheduled_at'],
                'scheduled_at',
                allowNull: true,
            );
        }

        return $parameters;
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    private function extractConfigurationParameters(array $parameters): array
    {
        unset($parameters['name']);

        return array_filter(
            $parameters,
            static fn (mixed $value, string $key): bool => $key !== 'name' && (
                $value !== null || in_array($key, [
                    'subject',
                    'preview_text',
                    'from_name',
                    'from_email',
                    'reply_to',
                    'template_uuid',
                    'segment_uuid',
                    'scheduled_at',
                    'timezone',
                ], true)
            ),
            ARRAY_FILTER_USE_BOTH,
        );
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    private function normalizeScheduleParameters(array $parameters): array
    {
        $sendImmediately = (bool) ($parameters['send_immediately'] ?? false);
        $timezone = $parameters['timezone'] ?? 'UTC';

        if (!is_string($timezone) || $timezone === '') {
            throw new InvalidArgumentException('The timezone field must be a non-empty IANA timezone string.');
        }

        $normalized = [
            'send_immediately' => $sendImmediately,
            'timezone' => $timezone,
        ];

        if ($sendImmediately) {
            return $normalized;
        }

        if (!array_key_exists('scheduled_at', $parameters) || $parameters['scheduled_at'] === null) {
            throw new InvalidArgumentException(
                'The scheduled_at field is required when send_immediately is false.'
            );
        }

        $normalized['scheduled_at'] = $this->normalizeDateTime(
            $parameters['scheduled_at'],
            'scheduled_at',
            allowNull: false,
        );

        return $normalized;
    }

    private function normalizeDateTime(mixed $value, string $field, bool $allowNull): ?DateTime
    {
        if ($value === null) {
            if ($allowNull) {
                return null;
            }

            throw new InvalidArgumentException(sprintf('The %s field is required.', $field));
        }

        // Generated ObjectSerializer only serializes `\DateTime`, not DateTimeImmutable.
        if ($value instanceof DateTime) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return DateTime::createFromInterface($value);
        }

        if (is_string($value) && $value !== '') {
            try {
                return new DateTime($value);
            } catch (Exception $exception) {
                throw new InvalidArgumentException(
                    sprintf('The %s field must be a valid ISO-8601 datetime string.', $field),
                    previous: $exception,
                );
            }
        }

        throw new InvalidArgumentException(
            sprintf('The %s field must be an ISO-8601 string or DateTimeInterface.', $field)
        );
    }

    private function campaignIdFromResponse(Response $response): string
    {
        $data = $response->data();
        $data = is_array($data) ? $data : [];
        $campaignId = $data['uuid'] ?? $data['id'] ?? null;

        if (!is_string($campaignId) || $campaignId === '') {
            throw new ApiException(
                message: 'Campaign was created but the response did not include a UUID.',
                statusCode: 500,
                responseBody: $response->toArray(),
            );
        }

        return $campaignId;
    }

    private function campaignsApi(): CampaignsApi
    {
        return $this->campaignsApi ??= new CampaignsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }

    private function lifecycleApi(): CampaignLifecycleApi
    {
        return $this->lifecycleApi ??= new CampaignLifecycleApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }

    private function analyticsApi(): CampaignAnalyticsApi
    {
        return $this->analyticsApi ??= new CampaignAnalyticsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }

    private function eventsApi(): CampaignEventsApi
    {
        return $this->eventsApi ??= new CampaignEventsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
