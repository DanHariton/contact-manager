<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TextTruncateExtension extends AbstractExtension
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('truncate_text', [$this, 'truncateText']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_truncated_text', [$this, 'renderTruncatedText'], ['is_safe' => ['html']]),
        ];
    }

    public function truncateText($text, $maxLength): string
    {
        if (mb_strlen($text) > $maxLength) {
            return mb_substr($text, 0, $maxLength);
        }

        return $text;
    }

    public function renderTruncatedText(string $text, int $maxLength, int $entityId): string
    {
        $truncatedText = $this->truncateText($text, $maxLength);

        if ($truncatedText !== $text) {
            $button = '<button 
                class="show-modal-button btn btn-info btn-sm text-white" 
                data-entity-id="' . $entityId . '" 
                data-text="' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '">
                ' . $this->translator->trans('button.more') . '
            </button>';
            $truncatedText .= '... ' . $button;
        }

        return $truncatedText;
    }
}