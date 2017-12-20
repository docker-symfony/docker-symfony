<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class EnforceStrictTypeTest extends TestCase
{
    public function test()
    {
        $directoryIterator = new \RecursiveDirectoryIterator(__DIR__ . '/../src');

        foreach ($this->findPhpFiles($directoryIterator) as $file) {
            $this->assertDeclaresStrictTypes($file);
        }
    }

    private function findPhpFiles(\RecursiveDirectoryIterator $iterator)
    {
        $files = [];
        while ($iterator->valid()) {
            if ($iterator->hasChildren()) {
                $files = array_merge($files, $this->findPhpFiles($iterator->getChildren()));
                break;
            }
            if ('php' !== $iterator->getExtension()) {
                $iterator->next();
                continue;
            }
            $files[] = $iterator->key();
            $iterator->next();
        }
        return $files;
    }

    private function assertDeclaresStrictTypes($filename)
    {
        $code = file_get_contents($filename);

        $line = preg_split('/\n/', $code);

        $this->assertEquals(
            'declare(strict_types=1);',
            $line[1],
            sprintf('"%s" does not declare strict types on first line', $filename)
        );
    }
}
