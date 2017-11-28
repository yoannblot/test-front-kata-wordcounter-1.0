<?php
declare(strict_types=1);

namespace YoannBlot\WordCounter;

use PHPUnit\Framework\TestCase;

/**
 * Class WordCounterTest.
 *
 * @package YoannBlot\WordCounter
 */
class WordCounterTest extends TestCase
{

    /**
     * Test to change minimum length with valid values.
     *
     * @dataProvider validMinLengthProvider
     *
     * @param int $iLength valid length.
     */
    public function testMinLengthValid(int $iLength): void
    {
        $oWordCounter = new WordCounter('test', $iLength);
        static::assertEquals($iLength, ReflectionHelper::getProperty($oWordCounter, 'iMinLength'));
    }

    /**
     * Test to change minimum length with invalid values.
     *
     * @dataProvider invalidMinLengthProvider
     *
     * @param int $iInvalidLength invalid length.
     */
    public function testMinLengthInvalid(int $iInvalidLength): void
    {
        $oWordCounter = new WordCounter('test', $iInvalidLength);
        static::assertNotEquals($iInvalidLength, ReflectionHelper::getProperty($oWordCounter, 'iMinLength'));
    }

    /**
     * @return array valid min length.
     */
    public function validMinLengthProvider(): array
    {
        return [
            'one' => [1],
            'two' => [2],
            'ten' => [10]
        ];
    }

    /**
     * @return array invalid min length.
     */
    public function invalidMinLengthProvider(): array
    {
        return [
            'negative' => [-10],
            'zero' => [0]
        ];
    }
}
