<?php

namespace Autoznetwork\AutozNetwork\Concerns;

use Saloon\Helpers\RequestExceptionHelper;
use Saloon\Http\Response;
use Throwable;

/**
 * Keeps exception messages readable when something in front of the API answers.
 *
 * The connector asks for JSON and throws on every error status, so Saloon's
 * default message inlines up to 2KB of the response body. That is right when
 * the body is the API's own structured error, and wrong when a maintenance
 * page, WAF block or load balancer replies in HTML regardless of the Accept
 * header: the whole document lands in every log line and Nightwatch issue.
 *
 * A non-JSON body carries no structured error to quote, so it is summarized
 * instead: status, content type, size and the document title, which is what
 * tells "down for maintenance" from "blocked by the WAF" at a glance. The
 * exception class is unchanged, so catch blocks keep matching on
 * ServiceUnavailableException and friends.
 */
trait SummarizesNonJsonErrors
{
    /**
     * How much of a document title to keep; enough for the longest real one.
     */
    protected const int MAX_TITLE_LENGTH = 120;

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        if ($this->hasJsonBody($response)) {
            return null;
        }

        $exception = RequestExceptionHelper::create($response, $senderException);
        $class = $exception::class;

        return new $class($response, $this->summarizeResponse($response), 0, $senderException);
    }

    /**
     * The human name used in summarized messages.
     */
    abstract protected function serviceName(): string;

    /**
     * Whether the body is the API's own structured error rather than a page
     * served by something in front of it.
     */
    protected function hasJsonBody(Response $response): bool
    {
        $contentType = strtolower($response->header('Content-Type') ?? '');

        if (str_contains($contentType, 'json')) {
            return true;
        }

        // An unlabelled body still counts as JSON when it parses as one; some
        // upstream errors omit the header.
        return trim($contentType) === '' && json_validate($response->body());
    }

    protected function summarizeResponse(Response $response): string
    {
        $body = $response->body();

        $parts = array_filter([
            $response->header('Content-Type') ?: 'unknown content type',
            number_format(strlen($body)).' bytes',
            $this->documentTitle($body),
        ]);

        return sprintf(
            '%s returned a non-JSON %d response (%s)',
            $this->serviceName(),
            $response->status(),
            implode(', ', $parts),
        );
    }

    /**
     * The `<title>` of an HTML error page, quoted, when there is one.
     */
    protected function documentTitle(string $body): ?string
    {
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $body, $matches) !== 1) {
            return null;
        }

        $title = trim(html_entity_decode(strip_tags($matches[1])));

        if ($title === '') {
            return null;
        }

        return '"'.mb_substr($title, 0, self::MAX_TITLE_LENGTH).'"';
    }
}
