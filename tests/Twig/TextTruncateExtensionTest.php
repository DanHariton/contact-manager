<?php

namespace App\Tests\Twig;

use App\Twig\TextTruncateExtension;
use Symfony\Contracts\Translation\TranslatorInterface;
use PHPUnit\Framework\TestCase;

class TextTruncateExtensionTest extends TestCase
{
    private TextTruncateExtension $textTruncateExtension;
    private TranslatorInterface $translator;

    protected function setUp(): void
    {
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->textTruncateExtension = new TextTruncateExtension($this->translator);
    }

    public function testTruncateText(): void
    {
        $text = 'Test text for test';
        $maxLength = 4;

        $result = $this->textTruncateExtension->truncateText($text, $maxLength);

        $this->assertEquals('Test', $result);
    }

    public function testRenderTruncatedText(): void
    {
        $text = 'This is a long text';
        $maxLength = 5;
        $entityId = 1;

        $this->translator
            ->expects($this->once())
            ->method('trans')
            ->willReturn('More');

        $result = $this->textTruncateExtension->renderTruncatedText($text, $maxLength, $entityId);

        $this->assertStringContainsString('This ...', $result);
        $this->assertStringContainsString('data-entity-id="1"', $result);
        $this->assertStringContainsString('data-text="This is a long text"', $result);
        $this->assertStringContainsString('More', $result);
    }
}