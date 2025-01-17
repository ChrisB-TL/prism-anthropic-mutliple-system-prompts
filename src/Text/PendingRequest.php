<?php

declare(strict_types=1);

namespace EchoLabs\Prism\Text;

use EchoLabs\Prism\Concerns\ConfiguresClient;
use EchoLabs\Prism\Concerns\ConfiguresGeneration;
use EchoLabs\Prism\Concerns\ConfiguresModels;
use EchoLabs\Prism\Concerns\ConfiguresProviders;
use EchoLabs\Prism\Concerns\ConfiguresTools;
use EchoLabs\Prism\Concerns\HasMessages;
use EchoLabs\Prism\Concerns\HasPrompts;
use EchoLabs\Prism\Concerns\HasProviderMeta;
use EchoLabs\Prism\Concerns\HasTools;
use EchoLabs\Prism\Exceptions\PrismException;
use EchoLabs\Prism\ValueObjects\Messages\UserMessage;

class PendingRequest
{
    use ConfiguresClient;
    use ConfiguresGeneration;
    use ConfiguresModels;
    use ConfiguresProviders;
    use ConfiguresTools;
    use HasMessages;
    use HasPrompts;
    use HasProviderMeta;
    use HasTools;

    public function generate(): Response
    {
        return (new Generator($this->provider))->generate($this->toRequest());
    }

    public function toRequest(): Request
    {
        if ($this->messages && $this->prompt) {
            throw PrismException::promptOrMessages();
        }

        if ($this->prompt) {
            $this->messages[] = new UserMessage($this->prompt);
        }

        return new Request(
            model: $this->model,
            systemPrompt: $this->systemPrompt,
            prompt: $this->prompt,
            messages: $this->messages,
            temperature: $this->temperature,
            maxTokens: $this->maxTokens,
            maxSteps: $this->maxSteps,
            topP: $this->topP,
            tools: $this->tools,
            clientOptions: $this->clientOptions,
            clientRetry: $this->clientRetry,
            toolChoice: $this->toolChoice,
            providerMeta: $this->providerMeta,
        );
    }
}
