<?php
declare(strict_types=1);

namespace functional\Evaneos\WordCounter;

use Evaneos\WordCounter\WordCounter;
use PHPUnit\Framework\TestCase;

/**
 * Class WordCounterTest.
 *
 * @package Evaneos\WordCounter
 */
class WordCounterTest extends TestCase {

    /**
     * @var WordCounter word counter.
     */
    private $oWordCounter = null;

    /**
     * Test words count.
     *
     * @dataProvider jsonFilesProvider
     *
     * @param string $sFileName file to parse.
     */
    public function testWordsCount (string $sFileName): void {
        $sFilePath = __DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . $sFileName;
        static::assertFileExists($sFilePath);

        $sContent = file_get_contents($sFilePath);
        $aJsonContents = json_decode($sContent, true);
        static::assertTrue(is_array($aJsonContents));
        static::assertArrayHasKey('input', $aJsonContents);
        static::assertArrayHasKey('expect', $aJsonContents);

        $sContent = $aJsonContents['input'];
        static::assertNotEmpty($sContent);
        $aExpectedOutput = $aJsonContents['expect'];
        static::assertNotEmpty($aExpectedOutput);

        $aOutput = $this->countWords($sContent);
        static::assertNotEmpty($aOutput);

        // check amount
        static::assertCount(count($aExpectedOutput), $aOutput);

        // check all values
        foreach ($aOutput as $sWord => $iCount) {
            static::assertArrayHasKey($sWord, $aExpectedOutput);
            static::assertEquals($aExpectedOutput[ $sWord ], $iCount);
        }
    }

    /**
     * Count words of given content.
     *
     * @param string $sContent content to parse and count.
     *
     * @return array word counts.
     */
    private function countWords (string $sContent): array {
        if (null === $this->oWordCounter) {
            $this->oWordCounter = new WordCounter($sContent, WordCounter::DEFAULT_MIN_LENGTH);
        } else {
            $this->oWordCounter->setContent($sContent);
        }

        return $this->oWordCounter->getWordCounts();
    }

    /**
     * @return array list of all files to parse and test.
     */
    public function jsonFilesProvider (): array {
        return [
            'french'  => ['french.json'],
            'russian' => ['russian.json'],
            'swedish' => ['swedish.json']
        ];
    }
}
