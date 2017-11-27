<?php
declare(strict_types=1);

namespace Evaneos\WordCounter;

/**
 * Class WordCounter.
 *
 * @package Evaneos\WordCounter
 */
class WordCounter {

    /**
     * @var int default minimum length.
     */
    const DEFAULT_MIN_LENGTH = 2;

    /**
     * @var string[] unexpected values to remove in content.
     */
    private const UNEXPECTED_VALUES = [
        ',',
        '.',
        ';',
        "'",
        ':',
        '?',
        '-'
    ];

    /**
     * @var string content to parse.
     */
    private $sContent;

    /**
     * @var int minimum length where starting count.
     */
    private $iMinLength;

    /**
     * @var array[] word counts.
     */
    private $aWordCounts = null;

    /**
     * WordCounter constructor.
     *
     * @param string $sContent
     * @param int $iMinLength
     */
    public function __construct (string $sContent, int $iMinLength = self::DEFAULT_MIN_LENGTH) {
        $this->setContent($sContent);
        $this->setMinLength($iMinLength);
    }

    /**
     * @param string $sContent
     */
    public function setContent (string $sContent): void {
        if (strlen($sContent) > 0) {
            $this->sContent = $sContent;
        }
        $this->reset();
    }

    /**
     * Reset current word counter.
     */
    private function reset (): void {
        $this->aWordCounts = null;
    }

    /**
     * @param int $iMinLength
     */
    public function setMinLength (int $iMinLength): void {
        if ($iMinLength <= 0) {
            $iMinLength = static::DEFAULT_MIN_LENGTH;
        }
        $this->iMinLength = $iMinLength;
        $this->reset();
    }

    /**
     * Get the word counts.
     *
     * @return array[] word counts.
     */
    public function getWordCounts (): array {
        $this->parse();

        return $this->aWordCounts;
    }

    /**
     * Parse current WordCounter.
     */
    private function parse (): void {
        // don't parse twice same contents
        if (null === $this->aWordCounts) {
            // step 1 : clean content, remove words less than minimum
            $sCleanContent = mb_strtolower($this->sContent, 'UTF-8');
            $sCleanContent = str_replace(static::UNEXPECTED_VALUES, ' ', $sCleanContent);
            $aWords = explode(' ', $sCleanContent);

            // step 2 : count words
            $this->aWordCounts = [];
            foreach (array_count_values($aWords) as $sWord => $iCount) {
                if (mb_strlen($sWord) >= $this->iMinLength) {
                    $this->aWordCounts [ $sWord ] = $iCount;
                }
            }

            // free content for saving memory
            unset($this->sContent);
        }
    }

}