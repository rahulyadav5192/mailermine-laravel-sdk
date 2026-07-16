<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\TemplatesApi;
use OpenAPI\Client\Model\CreateTemplateRequest;
use OpenAPI\Client\Model\DuplicateTemplateRequest;
use OpenAPI\Client\Model\PreviewTemplateRequest;
use OpenAPI\Client\Model\TestTemplateRequest;
use OpenAPI\Client\Model\UpdateTemplateRequest;

/**
 * Templates resource.
 *
 * Wraps {@see TemplatesApi}.
 */
final class Templates extends BaseResource
{
    private ?TemplatesApi $api = null;

    /**
     * Create an email template.
     *
     * @param array{
     *     name: string,
     *     description?: string|null,
     *     subject: string,
     *     html?: string|null,
     *     html_content?: string|null,
     *     text?: string|null,
     *     text_content?: string|null,
     *     status?: string,
     *     editor_type?: string,
     *     category?: string|null,
     *     tags?: list<string>,
     *     variables?: list<array<string, mixed>>,
     *     branding?: array<string, mixed>
     * } $parameters Template attributes.
     * @return Response The created template.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $template = $mm->templates()->create([
     *     'name' => 'Welcome Email',
     *     'subject' => 'Welcome {{first_name}}',
     *     'html' => '<h1>Welcome {{first_name}}</h1>',
     *     'text' => 'Welcome {{first_name}}',
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateTemplateRequest::class, $parameters);

        return $this->executeRequest($this->api()->createTemplateRequest($request));
    }

    /**
     * List templates with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     editor_type?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Template list filters.
     * @return Collection A collection of templates with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $templates = $mm->templates()->list([
     *     'status' => 'published',
     *     'editor_type' => 'code',
     * ]);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listTemplatesRequest(
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            $filters['editor_type'] ?? null,
            $filters['sort'] ?? 'created_at',
            $filters['direction'] ?? 'desc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve a template by UUID.
     *
     * @param  string  $templateId  Template UUID.
     * @return Response The requested template.
     *
     * @throws ApiException When the template cannot be retrieved.
     *
     * @example
     * $template = $mm->templates()->get('550e8400-e29b-41d4-a716-446655440000');
     */
    public function get(string $templateId): Response
    {
        return $this->executeRequest($this->api()->getTemplateRequest($templateId));
    }

    /**
     * Update a template.
     *
     * @param  string  $templateId  Template UUID.
     * @param array{
     *     name?: string,
     *     description?: string|null,
     *     subject?: string,
     *     html?: string|null,
     *     html_content?: string|null,
     *     text?: string|null,
     *     text_content?: string|null,
     *     status?: string,
     *     editor_type?: string,
     *     category?: string|null,
     *     tags?: list<string>,
     *     variables?: list<array<string, mixed>>,
     *     branding?: array<string, mixed>
     * } $parameters Attributes to update.
     * @return Response The updated template.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $template = $mm->templates()->update($templateId, [
     *     'subject' => 'Welcome to MailerMine, {{first_name}}',
     * ]);
     */
    public function update(string $templateId, array $parameters): Response
    {
        $request = RequestBuilder::make(UpdateTemplateRequest::class, $parameters);

        return $this->executeRequest($this->api()->updateTemplateRequest($templateId, $request));
    }

    /**
     * Delete a template.
     *
     * @param  string  $templateId  Template UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the template cannot be deleted.
     *
     * @example
     * $mm->templates()->delete('550e8400-e29b-41d4-a716-446655440000');
     */
    public function delete(string $templateId): Response
    {
        return $this->executeRequest($this->api()->deleteTemplateRequest($templateId));
    }

    /**
     * Duplicate a template.
     *
     * The server generates a copy name when `name` is omitted.
     *
     * @param  string  $templateId  Template UUID.
     * @param  array{name?: string}  $parameters  Duplicate options.
     * @return Response The duplicated template.
     *
     * @throws ApiException When the template cannot be duplicated.
     *
     * @example
     * $copy = $mm->templates()->duplicate($templateId, [
     *     'name' => 'Welcome Email Copy',
     * ]);
     */
    public function duplicate(string $templateId, array $parameters = []): Response
    {
        $request = RequestBuilder::make(DuplicateTemplateRequest::class, $parameters);

        return $this->executeRequest($this->api()->duplicateTemplateRequest($templateId, $request));
    }

    /**
     * Render a template with runtime variables without sending it.
     *
     * @param  string  $templateId  Template UUID.
     * @param  array<string, mixed>  $variables  Runtime template variables.
     * @return Response The rendered subject, HTML, and text.
     *
     * @throws ApiException When the template cannot be previewed.
     *
     * @example
     * $preview = $mm->templates()->preview($templateId, [
     *     'first_name' => 'John',
     * ]);
     *
     * echo $preview->data()['html'];
     */
    public function preview(string $templateId, array $variables = []): Response
    {
        $request = RequestBuilder::make(PreviewTemplateRequest::class, [
            'variables' => $variables,
        ]);

        return $this->executeRequest($this->api()->previewTemplateRequest($templateId, $request));
    }

    /**
     * Send a test message rendered from a template.
     *
     * `email` is accepted as a friendly alias for `to`.
     *
     * @param  string  $templateId  Template UUID.
     * @param array{
     *     to?: string,
     *     email?: string,
     *     variables?: array<string, mixed>,
     *     subject?: string|null
     * } $parameters Test recipient and rendering options.
     * @return Response The queued template test details.
     *
     * @throws ApiException When the test message cannot be queued.
     *
     * @example
     * $test = $mm->templates()->test($templateId, [
     *     'to' => 'john@example.com',
     *     'variables' => ['first_name' => 'John'],
     * ]);
     */
    public function test(string $templateId, array $parameters): Response
    {
        if (!isset($parameters['to']) && isset($parameters['email'])) {
            $parameters['to'] = $parameters['email'];
        }

        $request = RequestBuilder::make(TestTemplateRequest::class, $parameters);

        return $this->executeRequest($this->api()->testTemplateRequest($templateId, $request));
    }

    private function api(): TemplatesApi
    {
        return $this->api ??= new TemplatesApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
