<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;
use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\GenericPassbook;
use LauLamanApps\ApplePassbook\Passbook;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Compiler::class)]
final class CompilerTest extends TestCase
{
    public function testCompileUsesCompilerLevelIdentifiersWhenPassbookHasNone(): void
    {
        $passbook = new GenericPassbook('8j23fm3');
        $passbook->setOrganizationName('Toy Town');
        $passbook->setDescription('Toy Town Membership');

        $compiler = new Compiler(
            $this->createMock(ManifestGenerator::class),
            $this->createMock(Signer::class),
            $this->createCompressorWritingPass('<pkpass binary>'),
            'pass.com.toytown',
            '9X3HHK8VXA'
        );

        $result = $compiler->compile($passbook);

        self::assertSame('<pkpass binary>', $result);

        $data = $passbook->getData();
        self::assertSame('pass.com.toytown', $data['passTypeIdentifier']);
        self::assertSame('9X3HHK8VXA', $data['teamIdentifier']);
    }

    public function testCompileKeepsIdentifiersAlreadySetOnThePassbook(): void
    {
        $passbook = new GenericPassbook('8j23fm3');
        $passbook->setOrganizationName('Toy Town');
        $passbook->setDescription('Toy Town Membership');
        $passbook->setPassTypeIdentifier('pass.com.passbook-level');
        $passbook->setTeamIdentifier('PASSBOOK99');

        $compiler = new Compiler(
            $this->createMock(ManifestGenerator::class),
            $this->createMock(Signer::class),
            $this->createCompressorWritingPass('<pkpass binary>'),
            'pass.com.compiler-level',
            'COMPILER99'
        );

        $compiler->compile($passbook);

        $data = $passbook->getData();
        self::assertSame('pass.com.passbook-level', $data['passTypeIdentifier']);
        self::assertSame('PASSBOOK99', $data['teamIdentifier']);
    }

    public function testCompileThrowsWhenPassTypeIdentifierIsKnownNowhere(): void
    {
        $passbook = new GenericPassbook('8j23fm3');

        $compiler = new Compiler(
            $this->createMock(ManifestGenerator::class),
            $this->createMock(Signer::class),
            $this->createMock(Compressor::class),
        );

        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('PassTypeIdentifier is unknown.');

        $compiler->compile($passbook);
    }

    public function testCompileThrowsWhenTeamIdentifierIsKnownNowhere(): void
    {
        $passbook = new GenericPassbook('8j23fm3');
        $passbook->setPassTypeIdentifier('pass.com.toytown');

        $compiler = new Compiler(
            $this->createMock(ManifestGenerator::class),
            $this->createMock(Signer::class),
            $this->createMock(Compressor::class),
        );

        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('TeamIdentifier is unknown.');

        $compiler->compile($passbook);
    }

    private function createCompressorWritingPass(string $binary): Compressor
    {
        $compressor = $this->createMock(Compressor::class);
        $compressor
            ->expects($this->once())
            ->method('compress')
            ->willReturnCallback(static function (Passbook $passbook, string $temporaryDirectory) use ($binary): void {
                file_put_contents($temporaryDirectory . Compressor::FILENAME, $binary);
            });

        return $compressor;
    }
}
